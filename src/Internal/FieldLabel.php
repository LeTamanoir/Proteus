<?php

declare(strict_types=1);

namespace Proteus\Internal;

enum FieldLabel: string
{
    case Optional = 'optional';
    case Repeated = 'repeated';
}
