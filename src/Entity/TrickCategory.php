<?php

namespace App\Entity;

enum TrickCategory: string
{
    case jump = "Figures de sauts";
    case slide = "Figures de glissades";
    case spin = "Figures de rotations";
    case grabs = "Figures de grabs";
    case reverseGrab = "Figures de rotations inversées";
}
