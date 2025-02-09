<?php

namespace App;

enum UserRole: string
{
    case SISWA = "SISWA";
    case GURU = "GURU";
    case ADMIN = "ADMIN";
}