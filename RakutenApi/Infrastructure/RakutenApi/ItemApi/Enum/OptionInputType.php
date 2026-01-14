<?php
namespace RakutenApi\Infrastructure\RakutenApi\ItemApi\Enum;

enum OptionInputType:string{
    case SINGLE_SELECTION = "SINGLE_SELECTION";
    case MULTIPLE_SELECTION = "MULTIPLE_SELECTION";
    case FREE_TEXT = "FREE_TEXT";
}
