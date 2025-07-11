<?php

namespace Alex\Automag\Enum;

enum SuppliersTypesEnum: string
{
    case BIG = 'big';
    case SMALL = 'small';
    case PERSON = 'person';
    case COLLECTOR = 'collector';
    case OTHER = 'other';
}
