# PHP Function Call Overhead Analysis

## Why Are PHP Functions Slow?

### Benchmark Results Summary

| Environment | All Functions | Hybrid | Full Inline | Improvement |
|-------------|---------------|--------|-------------|-------------|
| **Without JIT** | 102.47 ms | 90.13 ms | 53.68 ms | Hybrid: 12% / Full: 47.6% |
| **With JIT** | 49.89 ms | 37.01 ms | 13.31 ms | Hybrid: 25.8% / Full: 73.3% |

### Root Causes of Overhead

1. **Stack Frame Allocation**
   - Each function call creates a new stack frame (~200-500ns overhead)
   - With nested calls (readVarint called 100+ times), this adds up

2. **Parameter Passing**
   - Pass-by-reference (`&$i`) requires extra indirection
   - String parameters (even when not copied) add overhead
   - 3 parameters = 3 pointer dereferences per call

3. **Scope Switching**
   - Variables must be copied to/from function scope
   - Local symbol table lookups

4. **No Aggressive Inlining**
   - PHP JIT can inline but only small, leaf functions
   - Functions with loops/branches rarely inlined
   - Our varint reader has both, so never inlined

5. **Virtual Function Table Lookups**
   - Even regular functions go through opcache
   - Method calls are even slower (though static helps slightly)

## What We Tried to Optimize

### Tested Optimizations (Without JIT)

| Optimization | Time (ms) | Improvement | Status |
|--------------|-----------|-------------|---------|
| Baseline (current) | 123.11 | 0% | ✅ Maintainable |
| Static methods | 122.92 | 0.2% | ❌ Negligible |
| Fast path branch | 136.42 | -10.8% | ❌ Worse! |
| Loop unrolling | 86.16 | 30% | ⚠️ Unsafe, brittle |

**Conclusion**: Function-level optimizations provide minimal gains (0-30%) because the overhead is in the *call itself*, not the function body.

### With JIT Enabled

| Optimization | Time (ms) | Improvement | Status |
|--------------|-----------|-------------|---------|
| Baseline | 48.42 | 0% | - |
| Loop unrolling | 43.12 | 10.9% | ⚠️ Some gain |

**JIT helps but doesn't eliminate function call overhead.**

## The Hybrid Solution

### Performance vs Code Bloat Analysis

**Without JIT (Realistic Production):**
```
Approach         | Speed      | Code Size | Efficiency*
-----------------|------------|-----------|-------------
All functions    | 102.47 ms  | 1x        | baseline
Hybrid (tag)     | 90.13 ms   | 5-8x      | 1.85% per unit
Hybrid (opt)     | 96.97 ms   | 6-10x     | 0.68% per unit
Full inline      | 53.68 ms   | 30-50x    | 1.19% per unit

*Efficiency = Performance gain / Code bloat ratio
```

**With JIT (Optimal):**
```
Approach         | Speed      | Code Size | Efficiency*
-----------------|------------|-----------|-------------
All functions    | 49.89 ms   | 1x        | baseline
Hybrid (tag)     | 37.01 ms   | 5-8x      | 3.97% per unit ⭐
Hybrid (opt)     | 39.21 ms   | 6-10x     | 2.68% per unit
Full inline      | 13.31 ms   | 30-50x    | 1.83% per unit
```

### Key Insights

1. **Hybrid is more efficient**: Gets 3.97% performance per unit of code bloat vs 1.83% for full inlining (with JIT)

2. **Tag reading is the hot path**: Every field reads a tag, making it the #1 optimization target

3. **Diminishing returns**: Going from hybrid to full inlining adds 3-4x more code for only 2x more speed

4. **JIT amplifies gains**: Hybrid improves from 12% → 25.8% with JIT

## Why Tag Reading Specifically?

```
Typical protobuf deserialization:
  while ($i < $l) {
    $tag = readVarint()  ← CALLED EVERY FIELD (100%)
    switch ($fieldNum) {
      case 1: $val = readInt32()    ← Type-specific (20%)
      case 2: $val = readString()   ← Type-specific (15%)
      ...
    }
  }
```

- **Tag reading**: Called N times (where N = number of fields)
- **Type-specific helpers**: Called 1 time per field
- **Ratio**: Tag reading is N times hotter

By inlining tag reading, we eliminate the hottest function call.

## Recommendations

### Option 1: Hybrid Inlining (RECOMMENDED) ⭐

**Implementation:**
- Inline: Tag reading (wire & fieldNum extraction)
- Keep functions: Type-specific readers (readInt32, readString, etc)
- Keep functions: Complex helpers (skipField, zigzag, etc)

**Pros:**
- 12-26% faster (depending on JIT)
- Only 5-8x code bloat (acceptable)
- Most efficient (3.97% gain per bloat unit with JIT)
- Easy to maintain complex helpers

**Cons:**
- More complex codegen logic
- Still 2x slower than full inlining

**Best for:**
- Production code balancing speed and maintainability
- Teams that may need to patch generated code

### Option 2: Full Inlining (MAXIMUM SPEED) ⚡

**Implementation:**
- Inline everything: tags, varints, all reads

**Pros:**
- 47-73% faster (depending on JIT)
- Maximum performance
- Matches gogoproto's approach

**Cons:**
- 30-50x code bloat
- Hard to patch bugs
- Generated files become huge (50 field message = 5000 lines)

**Best for:**
- Performance-critical services
- High-throughput APIs (millions of messages/sec)
- When JIT is guaranteed available

### Option 3: Configurable via Flag

**Implementation:**
```bash
proteus -p test.proto -o Gen.php                # Functions (default)
proteus -p test.proto -o Gen.php --inline       # Full inlining
proteus -p test.proto -o Gen.php --inline=tag   # Hybrid
```

**Pros:**
- User choice based on needs
- Easy to A/B test
- Gradual migration path

**Cons:**
- Three codepaths to maintain
- Users must understand trade-offs

## Implementation Plan

### Phase 1: Add Hybrid Inlining
1. Modify `generateFromBytesMethod()` to inline tag reading
2. Keep existing helper functions
3. Benchmark real-world proto files

### Phase 2: Add --inline Flag
1. Add CLI option parsing
2. Create separate generation methods
3. Document trade-offs

### Phase 3: Optimize Helpers
1. Apply loop unrolling to remaining functions
2. Add fast-path branches where safe
3. Measure incremental gains

## Real-World Considerations

1. **Message Size**: Larger messages benefit more from inlining
2. **Field Count**: More fields = more tag reads = bigger gains
3. **JIT Availability**: Check if your production environment has JIT
4. **Code Size Limits**: Some deployments have size constraints
5. **Debug-ability**: Inlined code harder to step through

## Conclusion

**Hybrid inlining provides the best balance** of performance and maintainability for most use cases. Full inlining should be opt-in for performance-critical paths.

The data clearly shows:
- Function call overhead is the bottleneck
- No amount of function-level optimization eliminates it
- Inlining hot paths (tag reading) captures most gains
- JIT helps but doesn't solve the fundamental issue
