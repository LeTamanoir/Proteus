# 🐙 Proteus

Known issues:

32 bit floats are not native in PHP, PHP only supports double (64 bit floats) so when decoding a 32bit serialized value you might endup with junk data due to the float32 to float64 conversion, for example: this `0.73484236` will become this `0.7348423600196838`.
