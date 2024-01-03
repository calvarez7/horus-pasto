<?php

namespace App\Http\Controllers\Pqrsfs;

use App\User;
use App\Modelos\Pqrsf;
use App\Modelos\Adjunto;
use App\Modelos\Cupspqrsf;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Modelos\Gestions_pqrsf;
use App\Modelos\Subcategoriaspqrsf;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Modelos\Detallearticulospqrsf;
use Illuminate\Support\Facades\Validator;

class PqrsfinternaController extends Controller
{

    private $holydays = [

        //--> Festivos 2019 <--\\
        "2019-10-14","2019-11-04","2019-11-11","2019-12-08","2019-12-25",
        "2019-09-14","2019-09-15","2019-09-21","2019-09-22","2019-09-28",
        "2019-09-29","2019-10-05","2019-10-06","2019-10-12","2019-10-13",
        "2019-10-19","2019-10-20","2019-10-26","2019-10-27","2019-11-02",
        "2019-11-03","2019-11-09","2019-11-10","2019-11-16","2019-11-17",
        "2019-11-23","2019-11-24","2019-11-30","2019-12-01","2019-12-07",
        "2019-12-08","2019-12-14","2019-12-15","2019-12-21","2019-12-22",
        "2019-12-28","2019-12-29",

        //--> Festivos 2020 <--\\
        "2020-01-01","2020-01-06","2020-03-23","2020-04-05","2020-04-09",
        "2020-04-10","2020-04-12","2020-05-01","2020-05-25","2020-06-15",
        "2020-06-22","2020-06-29","2020-07-20","2020-08-07","2020-08-17",
        "2020-10-12","2020-11-02","2020-11-16","2020-12-08","2020-12-25",
        "2020-01-04","2020-01-05","2020-01-11","2020-01-12","2020-01-18",
        "2020-01-19","2020-01-25","2020-01-26","2020-02-01","2020-02-02",
        "2020-02-08","2020-02-09","2020-02-15","2020-02-16","2020-02-22",
        "2020-02-23","2020-02-29","2020-03-01","2020-03-07","2020-03-08",
        "2020-03-14","2020-03-15","2020-03-21","2020-03-22","2020-03-28",
        "2020-03-29","2020-04-04","2020-04-05","2020-04-11","2020-04-12",
        "2020-04-18","2020-04-19","2020-04-25","2020-04-26","2020-05-02",
        "2020-05-03","2020-05-09","2020-05-09","2020-05-10","2020-05-16",
        "2020-05-17","2020-05-23","2020-05-24","2020-05-30","2020-05-31",
        "2020-06-06","2020-06-07","2020-06-13","2020-06-14","2020-06-20",
        "2020-06-21","2020-06-27","2020-06-28","2020-07-04","2020-07-05",
        "2020-07-11","2020-07-12","2020-07-18","2020-07-19","2020-07-25",
        "2020-07-26","2020-08-01","2020-08-02","2020-08-08","2020-08-09",
        "2020-08-15","2020-08-16","2020-08-22","2020-08-23","2020-08-29",
        "2020-08-30","2020-09-05","2020-09-06","2020-09-12","2020-09-13",
        "2020-09-19","2020-09-20","2020-09-26","2020-09-26","2020-09-27",
        "2020-10-03","2020-10-04","2020-10-10","2020-10-11","2020-10-17",
        "2020-10-18","2020-10-24","2020-10-25","2020-10-31","2020-11-01",
        "2020-11-02","2020-11-07","2020-11-08","2020-11-14","2020-11-15",
        "2020-11-21","2020-11-22","2020-11-28","2020-11-29","2020-12-05",
        "2020-12-06","2020-12-12","2020-12-13","2020-12-19","2020-12-20",
        "2020-12-26","2020-12-27",

        //--> Festivos 2021 <--\\
        "2021-01-01","2021-01-11","2021-03-22","2021-03-28","2021-04-01",
        "2021-04-02","2021-04-04","2021-05-01","2021-05-17","2021-06-07",
        "2021-06-14","2021-07-05","2021-07-20","2021-08-07","2021-08-16",
        "2021-10-18","2021-11-01","2021-11-15","2021-12-08","2021-12-25",
        "2021-01-02","2021-01-03","2021-01-09","2021-01-10","2021-01-16",
        "2021-01-17","2021-01-23","2021-01-24","2021-01-30","2021-01-31",
        "2021-02-06","2021-02-07","2021-02-13","2021-02-14","2021-02-20",
        "2021-02-21","2021-02-27","2021-02-28","2021-03-06","2021-03-07",
        "2021-03-13","2021-03-14","2021-03-20","2021-03-21","2021-03-27",
        "2021-03-28","2021-04-03","2021-04-04","2021-04-10","2021-04-11",
        "2021-04-17","2021-04-18","2021-04-24","2021-04-25","2021-05-01",
        "2021-05-02","2021-05-08","2021-05-09","2021-05-15","2021-05-16",
        "2021-05-22","2021-05-23","2021-05-29","2021-05-30","2021-06-05",
        "2021-06-06","2021-06-12","2021-06-13","2021-06-19","2021-06-20",
        "2021-06-26","2021-06-27","2021-07-03","2021-07-04","2021-07-10",
        "2021-07-11","2021-07-17","2021-07-18","2021-07-24","2021-07-25",
        "2021-07-31","2021-08-01","2021-08-07","2021-08-08","2021-08-14",
        "2021-08-15","2021-08-21","2021-08-22","2021-08-28","2021-08-29",
        "2021-09-04","2021-09-05","2021-09-11","2021-09-12","2021-09-18",
        "2021-09-19","2021-09-25","2021-09-26","2021-10-02","2021-10-03",
        "2021-10-09","2021-10-10","2021-10-16","2021-10-17","2021-10-23",
        "2021-10-24","2021-10-30","2021-10-31","2021-11-06","2021-11-07",
        "2021-11-13","2021-11-14","2021-11-20","2021-11-21","2021-11-27",
        "2021-11-28","2021-12-04","2021-12-05","2021-12-11","2021-12-12",
        "2021-12-18","2021-12-19","2021-12-25","2021-12-26",

        //--> Festivos 2022 <--\\
        "2022-01-01","2022-01-10","2022-03-21","2022-04-10","2022-04-14",
        "2022-04-15","2022-04-17","2022-05-01","2022-05-30","2022-06-20",
        "2022-06-27","2022-07-04","2022-07-20","2022-08-07","2022-08-15",
        "2022-10-17","2022-11-07","2022-11-14","2022-12-08","2022-12-25",
        "2022-01-01","2022-01-02","2022-01-08","2022-01-09","2022-01-15",
        "2022-01-16","2022-01-22","2022-01-23","2022-01-29","2022-01-30",
        "2022-02-05","2022-02-06","2022-02-12","2022-02-13","2022-02-19",
        "2022-02-20","2022-02-26","2022-02-27","2022-03-05","2022-03-06",
        "2022-03-12","2022-03-13","2022-03-19","2022-03-20","2022-03-26",
        "2022-03-27","2022-04-02","2022-04-03","2022-04-09","2022-04-10",
        "2022-04-16","2022-04-17","2022-04-23","2022-04-24","2022-04-30",
        "2022-05-01","2022-05-07","2022-05-08","2022-05-14","2022-05-15",
        "2022-05-21","2022-05-22","2022-05-28","2022-05-29","2022-06-04",
        "2022-06-05","2022-06-11","2022-06-12","2022-06-18","2022-06-19",
        "2022-06-25","2022-06-26","2022-07-02","2022-07-03","2022-07-09",
        "2022-07-10","2022-07-16","2022-07-17","2022-07-23","2022-07-24",
        "2022-07-30","2022-07-31","2022-08-06","2022-08-07","2022-08-13",
        "2022-08-14","2022-08-20","2022-08-21","2022-08-27","2022-08-28",
        "2022-09-03","2022-09-04","2022-09-10","2022-09-11","2022-09-17",
        "2022-09-18","2022-08-24","2022-09-25","2022-10-01","2022-10-02",
        "2022-10-08","2022-10-09","2022-10-15","2022-10-16","2022-10-22",
        "2022-20-23","2022-10-29","2022-10-30","2022-11-05","2022-11-06",
        "2022-11-12","2022-11-13","2022-11-19","2022-11-20","2022-11-26",
        "2022-11-27","2022-12-03","2022-12-04","2022-12-10","2022-12-11",
        "2022-12-17","2022-12-18","2022-12-24","2022-12-25","2022-12-31",

        //--> Festivos 2023 <--\\
        "2023-01-01","2023-01-09","2023-03-20","2023-04-02","2023-04-06",
        "2023-04-07","2023-04-09","2023-05-01","2023-05-22","2023-06-12",
        "2023-06-19","2023-07-03","2023-07-20","2023-08-07","2023-08-21",
        "2023-10-16","2023-11-06","2023-11-13","2023-12-08","2023-12-25",
        "2023-01-01","2023-01-07","2023-01-08","2023-01-14","2023-01-15",
        "2023-01-21","2023-01-22","2023-01-28","2023-01-29","2023-02-04",
        "2023-02-05","2023-02-11","2023-02-12","2023-02-18","2023-02-19",
        "2023-02-25","2023-02-26","2023-03-04","2023-03-05","2023-03-11",
        "2023-03-12","2023-03-18","2023-03-19","2023-03-25","2023-03-26",
        "2023-04-01","2023-04-02","2023-04-08","2023-04-09","2023-04-15",
        "2023-04-16","2023-04-22","2023-04-23","2023-04-29","2023-04-30",
        "2023-05-06","2023-05-07","2023-05-13","2023-05-14","2023-05-20",
        "2023-05-21","2023-05-27","2023-05-28","2023-06-03","2023-06-04",
        "2023-06-10","2023-06-11","2023-06-17","2023-06-18","2023-06-24",
        "2023-06-25","2023-07-01","2023-07-02","2023-07-08","2023-07-09",
        "2023-07-15","2023-07-16","2023-07-22","2023-07-23","2023-07-29",
        "2023-07-30","2023-08-05","2023-08-06","2023-08-12","2023-08-13",
        "2023-08-19","2023-08-20","2023-08-26","2023-08-27","2023-09-02",
        "2023-09-03","2023-09-09","2023-09-10","2023-09-16","2023-09-17",
        "2023-09-23","2023-09-24","2023-09-30","2023-10-01","2023-10-07",
        "2023-10-08","2023-10-14","2023-10-15","2023-10-21","2023-10-22",
        "2023-10-28","2023-10-29","2023-11-04","2023-11-05","2023-11-11",
        "2023-11-12","2023-11-18","2023-11-19","2023-11-25","2023-11-26",
        "2023-12-02","2023-12-03","2023-12-09","2023-12-10","2023-12-16",
        "2023-12-17","2023-12-23","2023-12-24","2023-12-30","2023-12-31",

        //--> Festivos 2024 <--\\
        "2024-01-01","2024-01-08","2024-03-24","2024-03-25","2024-03-28",
        "2024-03-29","2024-03-31","2024-05-01","2024-05-13","2024-06-03",
        "2024-06-10","2024-07-01","2024-07-20","2024-08-07","2024-08-19",
        "2024-10-14","2024-11-04","2024-11-11","2024-12-08","2024-12-25",
        "2024-01-01","2024-01-06","2024-01-07","2024-01-13","2024-01-14",
        "2025-01-20","2024-01-21","2024-01-27","2024-01-28","2024-02-03",
        "2024-02-04","2024-02-10","2024-02-11","2024-02-17","2024-02-18",
        "2024-02-24","2024-02-25","2024-03-02","2024-03-03","2024-03-09",
        "2024-03-10","2024-03-16","2024-03-17","2024-03-23","2024-03-24",
        "2024-03-30","2024-03-31","2024-04-06","2024-04-07","2024-04-13",
        "2024-04-14","2024-04-20","2024-04-21","2024-04-27","2024-04-28",
        "2024-05-04","2024-05-05","2024-05-11","2024-05-12","2024-05-18",
        "2024-05-19","2024-05-25","2024-05-26","2024-06-01","2024-06-02",
        "2024-06-08","2024-06-09","2024-06-15","2024-06-16","2024-06-22",
        "2024-06-23","2024-06-29","2024-06-30","2024-07-06","2024-07-07",
        "2024-07-13","2024-07-14","2024-07-20","2024-07-21","2024-07-27",
        "2024-07-28","2024-08-03","2024-08-04","2024-08-10","2024-08-11",
        "2024-08-17","2024-08-18","2024-08-24","2024-08-25","2024-08-31",
        "2024-09-07","2024-09-08","2024-09-14","2024-09-15","2024-09-21",
        "2024-09-22","2024-09-28","2024-09-29","2024-10-05","2024-10-06",
        "2024-10-12","2024-10-13","2024-10-19","2024-10-20","2024-10-26",
        "2024-10-27","2024-11-02","2024-11-03","2024-11-09","2024-11-10",
        "2024-11-16","2024-11-17","2024-11-23","2024-11-24","2024-11-30",
        "2024-12-01","2024-12-07","2024-12-08","2024-12-14","2024-12-15",
        "2024-12-21","2024-12-22","2024-12-28","2024-12-29",

        //--> Festivos 2025 <--\\
        "2025-01-01","2025-01-01","2025-01-06","2025-03-24","2025-04-13",
        "2025-04-17","2025-04-18","2025-04-20","2025-05-01","2025-06-02",
        "2025-06-23","2025-06-30","2025-06-30","2025-07-20","2025-08-07",
        "2025-08-18","2025-10-13","2025-11-03","2025-11-17","2025-12-08",
        "2025-12-25","2025-01-04","2025-01-05","2025-01-11","2025-01-12",
        "2025-01-18","2025-01-19","2025-01-25","2025-01-26","2025-02-01",
        "2025-02-02","2025-02-08","2025-02-09","2025-02-15","2025-02-16",
        "2024-02-22","2025-02-23","2025-03-01","2025-03-02","2025-03-08",
        "2025-03-09","2025-03-15","2025-03-16","2025-03-22","2025-03-23",
        "2025-03-29","2025-03-30","2025-04-05","2025-04-06","2025-04-12",
        "2025-04-13","2025-04-19","2025-04-20","2025-04-26","2025-04-27",
        "2025-05-03","2025-05-04","2025-05-10","2025-05-11","2025-05-17",
        "2025-05-18","2025-05-24","2025-05-25","2025-05-31","2025-06-01",
        "2025-06-07","2025-06-08","2025-06-14","2025-06-15","2025-06-21",
        "2025-06-22","2025-06-28","2025-06-29","2025-07-05","2025-07-06",
        "2025-07-12","2025-07-13","2025-07-19","2025-07-20","2025-07-26",
        "2025-07-27","2025-08-02","2025-08-03","2025-08-09","2025-08-10",
        "2025-08-16","2025-08-17","2025-08-23","2025-08-24","2025-08-30",
        "2025-08-31","2025-09-06","2025-09-07","2025-09-13","2025-09-14",
        "2025-09-20","2025-09-21","2025-09-27","2025-09-28","2025-10-04",
        "2025-10-05","2025-10-11","2025-10-12","2025-10-18","2025-10-19",
        "2025-10-25","2025-10-26","2025-11-01","2025-11-02","2025-11-08",
        "2025-11-09","2025-11-15","2025-11-16","2025-11-22","2025-11-23",
        "2025-11-29","2025-11-30","2025-12-06","2025-12-07","2025-12-13",
        "2025-12-14","2025-12-20","2025-12-21","2025-12-27","2025-12-28",

        //--> Festivos 2026 <--\\
        "2026-01-01","2026-01-12","2026-03-23","2026-03-29","2026-04-02",
        "2026-04-03","2026-04-05","2026-05-01","2026-05-18","2026-06-08",
        "2026-06-15","2026-06-29","2026-07-20","2026-08-07","2026-08-17",
        "2026-10-12","2026-11-02","2026-11-16","2026-12-08","2026-12-25",
        "2026-01-03","2026-01-04","2026-01-10","2026-01-11","2026-01-17",
        "2026-01-18","2026-01-24","2026-01-25","2026-01-31","2026-02-01",
        "2026-02-07","2026-02-08","2026-02-14","2026-02-15","2026-02-21",
        "2026-02-22","2026-02-28","2026-03-01","2026-03-07","2026-03-08",
        "2026-03-14","2026-03-15","2026-03-21","2025-03-22","2026-03-28",
        "2026-03-29","2026-04-04","2026-04-05","2026-04-11","2026-04-12",
        "2026-04-18","2026-04-19","2026-04-25","2026-04-26","2026-05-02",
        "2026-05-03","2026-05-09","2026-05-10","2026-05-16","2026-05-17",
        "2026-05-23","2026-05-24","2026-05-30","2026-05-31","2026-06-06",
        "2026-06-07","2026-06-13","2026-06-14","2026-06-20","2026-06-21",
        "2026-06-27","2026-06-28","2026-07-04","2026-07-05","2026-07-11",
        "2026-07-12","2026-07-18","2026-07-19","2026-07-25","2026-07-26",
        "2026-08-01","2026-08-02","2026-08-08","2026-08-09","2026-08-15",
        "2026-08-16","2026-08-22","2026-08-23","2026-08-29","2026-08-30",
        "2026-09-05","2026-09-06","2026-09-12","2026-09-13","2026-09-19",
        "2026-09-20","2026-09-26","2026-09-27","2026-10-03","2026-10-04",
        "2026-10-10","2026-10-11","2026-10-17","2026-10-18","2026-10-24",
        "2026-10-25","2026-10-31","2026-11-01","2026-11-07","2026-11-08",
        "2026-11-14","2026-11-15","2026-11-21","2026-11-22","2026-11-28",
        "2026-11-29","2026-12-05","2026-12-06","2026-12-12","2026-12-13",
        "2026-12-19","2026-12-20","2026-12-26","2026-12-27",

        //--> Festivos 2027 <--\\
        "2027-01-01","2027-01-11","2027-03-21","2027-03-22","2027-03-25",
        "2027-03-26","2027-03-28","2027-05-01","2027-05-10","2027-05-31",
        "2027-06-07","2027-07-05","2027-07-20","2027-08-07","2027-08-16",
        "2027-10-18","2027-11-01","2027-11-15","2027-12-08","2027-12-25",
        "2027-01-02","2027-01-03","2027-01-09","2027-01-10","2027-01-16",
        "2027-01-17","2027-01-23","2027-01-24","2027-01-30","2027-01-31",
        "2027-02-06","2027-02-07","2027-02-13","2027-02-14","2027-02-20",
        "2027-02-21","2027-02-27","2027-02-28","2027-03-06","2027-03-07",
        "2027-03-13","2027-03-14","2027-03-20","2027-03-21","2027-03-27",
        "2027-03-28","2027-04-03","2027-04-04","2027-04-10","2027-04-11",
        "2027-04-17","2027-04-18","2027-04-24","2027-04-25","2027-05-01",
        "2027-05-02","2027-05-08","2027-05-09","2027-05-15","2027-05-16",
        "2027-05-22","2027-05-23","2027-05-29","2027-05-30","2027-06-05",
        "2027-06-06","2027-06-12","2027-06-13","2027-06-19","2027-06-20",
        "2027-06-26","2027-06-27","2027-07-03","2027-07-04","2027-07-10",
        "2027-07-11","2027-07-17","2027-07-18","2027-07-24","2027-07-25",
        "2027-08-07","2027-08-08","2027-08-14","2027-08-15","2027-08-21",
        "2027-08-22","2027-08-28","2027-08-29","2027-09-04","2027-09-05",
        "2027-09-11","2027-09-12","2027-09-18","2027-09-19","2027-09-25",
        "2027-09-26","2027-10-02","2027-10-03","2027-10-09","2027-10-10",
        "2027-10-16","2027-10-17","2027-10-23","2027-10-24","2027-10-30",
        "2027-10-31","2027-11-06","2027-11-07","2027-11-13","2027-11-14",
        "2027-11-20","2027-11-21","2027-11-27","2027-11-28","2027-12-04",
        "2027-12-05","2027-12-11","2027-12-12","2027-12-18","2027-12-19",
        "2027-12-25","2027-12-26",

        //--> Festivos 2028 <--\\
        "2028-01-01","2028-01-10","2028-03-20","2028-04-09","2028-04-13",
        "2028-04-14","2028-04-16","2028-05-01","2028-05-29","2028-06-19",
        "2028-06-26","2028-07-03","2028-07-20","2028-08-07","2028-08-21",
        "2028-10-16","2028-11-06","2028-11-13","2028-12-08","2028-12-25",
        "2028-01-01","2028-01-02","2028-01-08","2028-01-09","2028-01-15",
        "2028-01-16","2028-01-22","2028-01-23","2028-01-29","2028-01-30",
        "2028-02-05","2028-02-06","2028-02-12","2028-02-13","2028-02-19",
        "2028-02-20","2028-02-26","2028-02-27","2028-03-04","2028-03-05",
        "2028-03-11","2028-03-12","2028-03-18","2028-03-19","2028-03-25",
        "2028-03-26","2028-04-01","2028-04-02","2028-04-08","2028-04-09",
        "2028-04-15","2028-04-16","2028-04-22","2028-04-23","2028-04-29",
        "2028-04-30","2028-05-06","2028-05-07","2028-05-13","2027-08-14",
        "2028-05-20","2028-05-21","2028-05-27","2028-05-28","2028-06-03",
        "2028-06-04","2028-06-10","2028-06-11","2028-06-17","2028-06-18",
        "2028-06-24","2028-06-25","2028-07-01","2028-07-02","2028-07-08",
        "2028-07-09","2028-07-15","2028-07-16","2028-07-22","2028-07-23",
        "2028-07-29","2028-07-30","2028-08-05","2028-08-06","2028-08-12",
        "2028-08-13","2028-08-19","2028-08-20","2028-08-26","2028-08-27",
        "2028-09-02","2028-09-03","2028-09-09","2028-09-10","2028-09-16",
        "2028-09-17","2028-09-23","2028-09-24","2028-09-30","2028-10-01",
        "2028-10-07","2028-10-08","2028-10-14","2028-10-15","2028-10-21",
        "2028-10-22","2028-10-28","2028-10-29","2028-11-04","2028-11-05",
        "2028-11-11","2028-11-12","2028-11-18","2028-11-19","2028-11-25",
        "2028-11-26","2028-12-02","2028-12-03","2028-12-09","2028-12-10",
        "2028-12-16","2028-12-17","2028-12-23","2028-12-24","2028-12-30",
        "2028-12-31",

        //--> Festivos 2029 <--\\
        "2029-01-01","2029-01-08","2029-03-19","2029-03-25","2029-03-29",
        "2029-03-30","2029-04-01","2029-05-01","2029-05-14","2029-06-04",
        "2029-06-11","2029-07-02","2029-07-20","2029-08-07","2029-08-20",
        "2029-10-15","2029-11-05","2029-11-12","2029-12-08","2029-12-25",
        "2029-01-06","2029-01-07","2029-01-13","2029-01-14","2029-01-20",
        "2029-01-21","2029-01-27","2029-01-28","2029-02-03","2029-02-04",
        "2029-02-10","2029-02-11","2029-02-17","2029-02-18","2029-02-24",
        "2029-02-25","2029-03-03","2029-03-04","2029-03-10","2029-03-11",
        "2029-03-17","2029-03-18","2029-03-24","2029-03-25","2029-03-31",
        "2029-04-01","2029-04-07","2029-04-08","2029-04-14","2029-04-15",
        "2029-04-21","2029-04-22","2029-04-28","2029-04-29","2029-05-05",
        "2029-05-06","2029-05-12","2029-05-13","2028-05-19","2029-05-20",
        "2029-05-26","2029-05-27","2029-06-02","2029-06-03","2029-06-09",
        "2029-06-10","2029-06-16","2029-06-17","2029-06-23","2029-06-24",
        "2029-06-30","2029-07-01","2029-07-07","2029-07-08","2029-07-14",
        "2029-07-15","2029-07-21","2029-07-22","2029-07-28","2029-07-29",
        "2029-08-04","2029-08-05","2029-08-11","2029-08-12","2029-08-18",
        "2029-08-19","2029-08-25","2029-08-26","2029-09-01","2029-09-02",
        "2029-09-08","2029-09-09","2029-09-15","2029-09-16","2029-09-22",
        "2029-09-23","2029-09-29","2029-09-30","2029-10-06","2029-10-07",
        "2029-10-13","2029-10-14","2029-10-20","2029-10-21","2029-10-27",
        "2029-10-28","2028-11-03","2029-11-04","2029-11-10","2029-10-11",
        "2029-11-17","2029-11-18","2029-11-24","2029-11-25","2029-12-01",
        "2029-12-02","2029-12-08","2029-12-09","2029-12-15","2029-12-16",
        "2029-12-22","2029-12-23","2029-12-29","2029-12-30",

        //--> Festivos 2030 <--\\
        "2030-01-01","2030-01-07","2030-03-25","2030-04-14","2030-04-18",
        "2030-04-19","2030-04-21","2030-05-01","2030-06-03","2030-06-24",
        "2030-07-01","2030-07-01","2030-07-20","2030-08-07","2030-08-19",
        "2030-10-14","2030-11-04","2030-11-11","2030-12-08","2030-12-25",

    ];


    public function slope()
    {
        $permisos    = Auth::user()->permissions;
        $permisoname = [];
        foreach ($permisos as $permiso) {
            array_push($permisoname, $permiso->name);
        }
        $adminpqrsf = array_search("Admin Pqrsf", $permisoname);
        $admin        = var_export($adminpqrsf, true);

        $user = Auth::user()->id;

        if ($admin == "false") {
            $pqrsfs = Pqrsf::select(['Pqrsfs.Email', 'Pqrsfs.Afec_numdoc as doc','Pqrsfs.Canal',
            'pqrsfs.id','Pacientes.Num_Doc as cc', 'Pacientes.Primer_Nom as Nombre', 'pqrsfs.created_at',
            'pqrsfs.Tiposolicitud as Solicitud', 'Sedeproveedores.Nombre as IPS', 'Pacientes.Primer_Ape as Apellido',
            'pqrsfs.Telefono as Telefono', 'pqrsfs.Descripcion', 'pqrsfs.Reabierta', 'pqrsfs.Priorizacion',
            'pqrsfs.Atr_calidad', 'pqrsfs.Tiposolicitud', 'Pacientes.id as Paciente_id', 'Pacientes.Edad_Cumplida',
            'pqrsfs.derecho', 'pqrsfs.deber'])
            ->leftjoin('Pacientes', 'Pqrsfs.Paciente_id', 'Pacientes.id')
            ->leftjoin('Sedeproveedores', 'Pacientes.IPS', 'Sedeproveedores.id')
            ->join('gestions_pqrsf', 'gestions_pqrsf.Pqrsf_id', 'Pqrsfs.id')
            ->with(['Subcategoriaspqrsf' => function ($query) {
                $query->select('Subcategoriaspqrsf.Subcategoria_id', 'Subcategoriaspqrsf.Pqrsf_id', 'sub.Nombre')
                    ->join('Subcategorias as sub', 'Subcategoriaspqrsf.Subcategoria_id', 'sub.id')
                    ->get();
            }])
            ->with(['Gestion_pqrsfs' => function ($query){
                $query->select('gestions_pqrsf.id', 'gestions_pqrsf.Pqrsf_id', 'gestions_pqrsf.Motivo',
                'users.name', 'users.apellido')
                ->leftjoin('users', 'User_id', 'users.id')
                ->where('gestions_pqrsf.Tipo_id', 3)
                    ->with(['Adjuntos_pqrsf' => function ($query) {
                        $query->select('Ruta', 'Gestion_id')
                            ->get();
                    }])
                    ->get();
            }])
            ->where('gestions_pqrsf.User_id', $user)
            ->where('Pqrsfs.Estado_id', 18)
            ->whereNotIn('Pqrsfs.Canal', ['Web', 'Supersalud'])
            ->distinct()
            ->get();

                foreach ($pqrsfs as $pqrsf) {
                    $fecha1 = Carbon::now()->format('Y-m-d');
                    $fecha2 = Carbon::parse($pqrsf->created_at->format('Y-m-d'));
                    $diasDiferencia = $fecha2->diffInDays($fecha1);
                    foreach ($this->holydays as $holyday) {
                        $exFecha1 = explode('-', $fecha1);
                        $exFecha2 = explode('-', $fecha2);
                        $exHolyday = explode('-', $holyday);
                        if(intval($exFecha2[0]) <= intval($exHolyday[0]) && intval($exFecha1[0]) >= intval($exHolyday[0])){
                            if(intval($exFecha2[1]) <= intval($exHolyday[1]) && intval($exFecha1[1]) >= intval($exHolyday[1])){
                                if(intval($exFecha2[2]) <= intval($exHolyday[2]) && intval($exFecha1[2]) >= intval($exHolyday[2])){
                                    $diasDiferencia--;
                                }
                            }
                        }
                    }
                    if ($diasDiferencia < 0){
                        $diasDiferencia = 0;
                    }
                    $pqrsf['diasHabiles'] = $diasDiferencia;
                }

            return response()->json($pqrsfs, 201);

        }else {
            $pqrsfs = Pqrsf::select(['Pqrsfs.Email', 'Pqrsfs.Afec_numdoc as doc','Pqrsfs.Canal',
            'pqrsfs.id','Pacientes.Num_Doc as cc', 'Pacientes.Primer_Nom as Nombre', 'pqrsfs.created_at',
            'pqrsfs.Tiposolicitud as Solicitud', 'Sedeproveedores.Nombre as IPS', 'Pacientes.Primer_Ape as Apellido',
            'pqrsfs.Telefono as Telefono', 'pqrsfs.Descripcion', 'pqrsfs.Reabierta', 'pqrsfs.Priorizacion',
            'pqrsfs.Atr_calidad', 'pqrsfs.Tiposolicitud', 'Pacientes.id as Paciente_id', 'Pacientes.Edad_Cumplida',
            'pqrsfs.derecho', 'pqrsfs.deber'])
            ->leftjoin('Pacientes', 'Pqrsfs.Paciente_id', 'Pacientes.id')
            ->leftjoin('Sedeproveedores', 'Pacientes.IPS', 'Sedeproveedores.id')
            ->join('gestions_pqrsf', 'gestions_pqrsf.Pqrsf_id', 'Pqrsfs.id')
            ->with(['Subcategoriaspqrsf' => function ($query) {
                $query->select('Subcategoriaspqrsf.Subcategoria_id', 'Subcategoriaspqrsf.Pqrsf_id', 'sub.Nombre')
                    ->join('Subcategorias as sub', 'Subcategoriaspqrsf.Subcategoria_id', 'sub.id')
                    ->get();
            }])
            ->with(['Gestion_pqrsfs' => function ($query){
                $query->select('gestions_pqrsf.id', 'gestions_pqrsf.Pqrsf_id', 'gestions_pqrsf.Motivo',
                'users.name', 'users.apellido')
                ->leftjoin('users', 'User_id', 'users.id')
                ->where('gestions_pqrsf.Tipo_id', 3)
                    ->with(['Adjuntos_pqrsf' => function ($query) {
                        $query->select('Ruta', 'Gestion_id')
                            ->get();
                    }])
                    ->get();
            }])
            ->where('Pqrsfs.Estado_id', 18)
            ->whereNotIn('Pqrsfs.Canal', ['Web', 'Supersalud'])
            ->distinct()
            ->get();

                foreach ($pqrsfs as $pqrsf) {
                    $fecha1 = Carbon::now()->format('Y-m-d');
                    $fecha2 = Carbon::parse($pqrsf->created_at->format('Y-m-d'));
                    $diasDiferencia = $fecha2->diffInDays($fecha1);
                    foreach ($this->holydays as $holyday) {
                        $exFecha1 = explode('-', $fecha1);
                        $exFecha2 = explode('-', $fecha2);
                        $exHolyday = explode('-', $holyday);
                        if(intval($exFecha2[0]) <= intval($exHolyday[0]) && intval($exFecha1[0]) >= intval($exHolyday[0])){
                            if(intval($exFecha2[1]) <= intval($exHolyday[1]) && intval($exFecha1[1]) >= intval($exHolyday[1])){
                                if(intval($exFecha2[2]) <= intval($exHolyday[2]) && intval($exFecha1[2]) >= intval($exHolyday[2])){
                                    $diasDiferencia--;
                                }
                            }
                        }
                    }
                    if ($diasDiferencia < 0){
                        $diasDiferencia = 0;
                    }
                    $pqrsf['diasHabiles'] = $diasDiferencia;
                }

            return response()->json($pqrsfs, 201);
        }
    }

    public function assigned()
    {
        $permisos    = Auth::user()->permissions;
        $permisoname = [];
        foreach ($permisos as $permiso) {
            array_push($permisoname, $permiso->name);
        }
        $adminpqrsf = array_search("Admin Pqrsf", $permisoname);
        $admin        = var_export($adminpqrsf, true);

        $user = Auth::user()->id;

        if ($admin == "false") {
            $pqrsfs = Pqrsf::select(['Pqrsfs.Email', 'Pqrsfs.Afec_numdoc as doc','Pqrsfs.Canal',
            'pqrsfs.id','Pacientes.Num_Doc as cc', 'Pacientes.Primer_Nom as Nombre', 'pqrsfs.created_at',
            'pqrsfs.Tiposolicitud as Solicitud', 'Sedeproveedores.Nombre as IPS', 'Pacientes.Primer_Ape as Apellido',
            'pqrsfs.Telefono as Telefono', 'pqrsfs.Descripcion', 'pqrsfs.derecho','pqrsfs.deber', 'pqrsfs.Reabierta', 'pqrsfs.Priorizacion',
            'pqrsfs.Atr_calidad', 'pqrsfs.Tiposolicitud', 'Pacientes.id as Paciente_id', 'Pacientes.Edad_Cumplida'])
            ->leftjoin('Pacientes', 'Pqrsfs.Paciente_id', 'Pacientes.id')
            ->leftjoin('Sedeproveedores', 'Pacientes.IPS', 'Sedeproveedores.id')
            ->join('gestions_pqrsf', 'gestions_pqrsf.Pqrsf_id', 'Pqrsfs.id')
            ->with(['Subcategoriaspqrsf' => function ($query) {
                $query->select('Subcategoriaspqrsf.Subcategoria_id', 'Subcategoriaspqrsf.Pqrsf_id', 'sub.Nombre')
                    ->join('Subcategorias as sub', 'Subcategoriaspqrsf.Subcategoria_id', 'sub.id')
                    ->get();
            }])
            ->with(['Gestion_pqrsfs' => function ($query) {
                $query->select('gestions_pqrsf.id', 'gestions_pqrsf.Pqrsf_id', 'gestions_pqrsf.Tipo_id', 'gestions_pqrsf.Motivo',
                'users.name', 'users.apellido', 'gestions_pqrsf.created_at', 'gestions_pqrsf.Responsable')
                    ->leftjoin('users', 'User_id', 'users.id')
                    ->with(['Adjuntos_pqrsf' => function ($query) {
                        $query->select('Ruta', 'Gestion_id')
                            ->get();
                    }])
                    ->get();
            }])
            ->with(['Permisospqrsf' => function ($query) {
                $query->select('Pqrsf_id', 'Permission_id', 'pe.name')
                    ->join('permissions as pe', 'Permission_id', 'pe.id')
                    ->where('Estado_id', 1)
                    ->get();
            }])
            ->where('gestions_pqrsf.User_id', $user)
            ->whereIn('Pqrsfs.Estado_id', [5,24,11])
            ->whereNotIn('Pqrsfs.Canal', ['Web', 'Supersalud'])
            ->distinct()
            ->get();

            foreach ($pqrsfs as $pqrsf) {
                $fecha1 = Carbon::now()->format('Y-m-d');
                $fecha2 = Carbon::parse($pqrsf->created_at->format('Y-m-d'));
                $diasDiferencia = $fecha2->diffInDays($fecha1);
                foreach ($this->holydays as $holyday) {
                    $exFecha1 = explode('-', $fecha1);
                    $exFecha2 = explode('-', $fecha2);
                    $exHolyday = explode('-', $holyday);
                    if(intval($exFecha2[0]) <= intval($exHolyday[0]) && intval($exFecha1[0]) >= intval($exHolyday[0])){
                        if(intval($exFecha2[1]) <= intval($exHolyday[1]) && intval($exFecha1[1]) >= intval($exHolyday[1])){
                            if(intval($exFecha2[2]) <= intval($exHolyday[2]) && intval($exFecha1[2]) >= intval($exHolyday[2])){
                                $diasDiferencia--;
                            }
                        }
                    }
                }
                if ($diasDiferencia < 0){
                    $diasDiferencia = 0;
                }
                $pqrsf['diasHabiles'] = $diasDiferencia;
            }

            return response()->json($pqrsfs, 201);
        }else {
            $pqrsfs = Pqrsf::select(['Pqrsfs.Email', 'Pqrsfs.Afec_numdoc as doc','Pqrsfs.Canal',
            'pqrsfs.id','Pacientes.Num_Doc as cc', 'Pacientes.Primer_Nom as Nombre', 'pqrsfs.created_at',
            'pqrsfs.Tiposolicitud as Solicitud', 'Sedeproveedores.Nombre as IPS', 'Pacientes.Primer_Ape as Apellido',
            'pqrsfs.Telefono as Telefono', 'pqrsfs.Descripcion', 'pqrsfs.Reabierta', 'pqrsfs.Priorizacion',
            'pqrsfs.Atr_calidad', 'pqrsfs.Tiposolicitud', 'Pacientes.id as Paciente_id', 'Pacientes.Edad_Cumplida'])
            ->leftjoin('Pacientes', 'Pqrsfs.Paciente_id', 'Pacientes.id')
            ->leftjoin('Sedeproveedores', 'Pacientes.IPS', 'Sedeproveedores.id')
            ->join('gestions_pqrsf', 'gestions_pqrsf.Pqrsf_id', 'Pqrsfs.id')
            ->with(['Subcategoriaspqrsf' => function ($query) {
                $query->select('Subcategoriaspqrsf.Subcategoria_id', 'Subcategoriaspqrsf.Pqrsf_id', 'sub.Nombre')
                    ->join('Subcategorias as sub', 'Subcategoriaspqrsf.Subcategoria_id', 'sub.id')
                    ->get();
            }])
            ->with(['Gestion_pqrsfs' => function ($query) {
                $query->select('gestions_pqrsf.id', 'gestions_pqrsf.Pqrsf_id', 'gestions_pqrsf.Tipo_id', 'gestions_pqrsf.Motivo',
                'users.name', 'users.apellido', 'gestions_pqrsf.created_at', 'gestions_pqrsf.Responsable')
                    ->leftjoin('users', 'User_id', 'users.id')
                    ->with(['Adjuntos_pqrsf' => function ($query) {
                        $query->select('Ruta', 'Gestion_id')
                            ->get();
                    }])
                    ->get();
            }])
            ->with(['Permisospqrsf' => function ($query) {
                $query->select('Pqrsf_id', 'Permission_id', 'pe.name')
                    ->join('permissions as pe', 'Permission_id', 'pe.id')
                    ->where('Estado_id', 1)
                    ->get();
            }])
            ->whereIn('Pqrsfs.Estado_id', [5,24,11])
            ->whereNotIn('Pqrsfs.Canal', ['Web', 'Supersalud'])
            ->distinct()
            ->get();

            foreach ($pqrsfs as $pqrsf) {
                $fecha1 = Carbon::now()->format('Y-m-d');
                $fecha2 = Carbon::parse($pqrsf->created_at->format('Y-m-d'));
                $diasDiferencia = $fecha2->diffInDays($fecha1);
                foreach ($this->holydays as $holyday) {
                    $exFecha1 = explode('-', $fecha1);
                    $exFecha2 = explode('-', $fecha2);
                    $exHolyday = explode('-', $holyday);
                    if(intval($exFecha2[0]) <= intval($exHolyday[0]) && intval($exFecha1[0]) >= intval($exHolyday[0])){
                        if(intval($exFecha2[1]) <= intval($exHolyday[1]) && intval($exFecha1[1]) >= intval($exHolyday[1])){
                            if(intval($exFecha2[2]) <= intval($exHolyday[2]) && intval($exFecha1[2]) >= intval($exHolyday[2])){
                                $diasDiferencia--;
                            }
                        }
                    }
                }
                if ($diasDiferencia < 0){
                    $diasDiferencia = 0;
                }
                $pqrsf['diasHabiles'] = $diasDiferencia;
            }

            return response()->json($pqrsfs, 201);
        }
    }

    public function pre_solution()
    {
        $permisos    = Auth::user()->permissions;
        $permisoname = [];
        foreach ($permisos as $permiso) {
            array_push($permisoname, $permiso->name);
        }
        $adminpqrsf = array_search("Admin Pqrsf", $permisoname);
        $admin        = var_export($adminpqrsf, true);

        $user = Auth::user()->id;

        if ($admin == "false") {
            $pqrsfs = Pqrsf::select(['Pqrsfs.Email', 'Pqrsfs.Afec_numdoc as doc','Pqrsfs.Canal',
            'pqrsfs.id','Pacientes.Num_Doc as cc', 'Pacientes.Primer_Nom as Nombre', 'pqrsfs.created_at',
            'pqrsfs.Tiposolicitud as Solicitud', 'Sedeproveedores.Nombre as IPS', 'Pacientes.Primer_Ape as Apellido',
            'pqrsfs.Telefono as Telefono', 'pqrsfs.Descripcion', 'pqrsfs.Reabierta', 'pqrsfs.Priorizacion',
            'pqrsfs.Atr_calidad', 'pqrsfs.Tiposolicitud', 'Pacientes.id as Paciente_id', 'Pacientes.Edad_Cumplida'])
            ->leftjoin('Pacientes', 'Pqrsfs.Paciente_id', 'Pacientes.id')
            ->leftjoin('Sedeproveedores', 'Pacientes.IPS', 'Sedeproveedores.id')
            ->join('gestions_pqrsf', 'gestions_pqrsf.Pqrsf_id', 'Pqrsfs.id')
            ->with(['Subcategoriaspqrsf' => function ($query) {
                $query->select('Subcategoriaspqrsf.Subcategoria_id', 'Subcategoriaspqrsf.Pqrsf_id', 'sub.Nombre')
                    ->join('Subcategorias as sub', 'Subcategoriaspqrsf.Subcategoria_id', 'sub.id')
                    ->get();
            }])
            ->with(['Gestion_pqrsfs' => function ($query) {
                $query->select('gestions_pqrsf.id', 'gestions_pqrsf.Pqrsf_id', 'gestions_pqrsf.Tipo_id', 'gestions_pqrsf.Motivo',
                'users.name', 'users.apellido', 'gestions_pqrsf.created_at', 'gestions_pqrsf.Responsable')
                    ->leftjoin('users', 'User_id', 'users.id')
                    ->with(['Adjuntos_pqrsf' => function ($query) {
                        $query->select('Ruta', 'Gestion_id')
                            ->get();
                    }])
                    ->get();
            }])
            ->with(['Permisospqrsf' => function ($query) {
                $query->select('Pqrsf_id', 'Permission_id', 'pe.name')
                    ->join('permissions as pe', 'Permission_id', 'pe.id')
                    ->get();
            }])
            ->where('gestions_pqrsf.User_id', $user)
            ->where('gestions_pqrsf.Tipo_id', 3)
            ->where('pqrsfs.Estado_id', 19)
            ->whereNotIn('pqrsfs.Canal', ['Web', 'Supersalud'])
            ->distinct()
            ->get();

            foreach ($pqrsfs as $pqrsf) {
                $fecha1 = Carbon::now()->format('Y-m-d');
                $fecha2 = Carbon::parse($pqrsf->created_at->format('Y-m-d'));
                $diasDiferencia = $fecha2->diffInDays($fecha1);
                foreach ($this->holydays as $holyday) {
                    $exFecha1 = explode('-', $fecha1);
                    $exFecha2 = explode('-', $fecha2);
                    $exHolyday = explode('-', $holyday);
                    if(intval($exFecha2[0]) <= intval($exHolyday[0]) && intval($exFecha1[0]) >= intval($exHolyday[0])){
                        if(intval($exFecha2[1]) <= intval($exHolyday[1]) && intval($exFecha1[1]) >= intval($exHolyday[1])){
                            if(intval($exFecha2[2]) <= intval($exHolyday[2]) && intval($exFecha1[2]) >= intval($exHolyday[2])){
                                $diasDiferencia--;
                            }
                        }
                    }
                }
                if ($diasDiferencia < 0){
                    $diasDiferencia = 0;
                }
                $pqrsf['diasHabiles'] = $diasDiferencia;
            }

            return response()->json($pqrsfs, 201);
        }else{
            $pqrsfs = Pqrsf::select(['Pqrsfs.Email', 'Pqrsfs.Afec_numdoc as doc','Pqrsfs.Canal',
        'pqrsfs.id','Pacientes.Num_Doc as cc', 'Pacientes.Primer_Nom as Nombre', 'pqrsfs.created_at',
        'pqrsfs.Tiposolicitud as Solicitud', 'Sedeproveedores.Nombre as IPS', 'Pacientes.Primer_Ape as Apellido',
        'pqrsfs.Telefono as Telefono', 'pqrsfs.Descripcion', 'pqrsfs.Reabierta', 'pqrsfs.Priorizacion',
        'pqrsfs.Atr_calidad', 'pqrsfs.Tiposolicitud', 'Pacientes.id as Paciente_id', 'Pacientes.Edad_Cumplida'])
        ->leftjoin('Pacientes', 'Pqrsfs.Paciente_id', 'Pacientes.id')
        ->leftjoin('Sedeproveedores', 'Pacientes.IPS', 'Sedeproveedores.id')
        ->join('gestions_pqrsf', 'gestions_pqrsf.Pqrsf_id', 'Pqrsfs.id')
        ->with(['Subcategoriaspqrsf' => function ($query) {
            $query->select('Subcategoriaspqrsf.Subcategoria_id', 'Subcategoriaspqrsf.Pqrsf_id', 'sub.Nombre')
                ->join('Subcategorias as sub', 'Subcategoriaspqrsf.Subcategoria_id', 'sub.id')
                ->get();
        }])
        ->with(['Gestion_pqrsfs' => function ($query) {
            $query->select('gestions_pqrsf.id', 'gestions_pqrsf.Pqrsf_id', 'gestions_pqrsf.Tipo_id', 'gestions_pqrsf.Motivo',
            'users.name', 'users.apellido', 'gestions_pqrsf.created_at', 'gestions_pqrsf.Responsable')
                ->leftjoin('users', 'User_id', 'users.id')
                ->with(['Adjuntos_pqrsf' => function ($query) {
                    $query->select('Ruta', 'Gestion_id')
                        ->get();
                }])
                ->get();
        }])
        ->with(['Permisospqrsf' => function ($query) {
            $query->select('Pqrsf_id', 'Permission_id', 'pe.name')
                ->join('permissions as pe', 'Permission_id', 'pe.id')
                ->get();
        }])
        ->where('pqrsfs.Estado_id', 19)
        ->whereNotIn('pqrsfs.Canal', ['Web', 'Supersalud'])
        ->distinct()
        ->get();

        foreach ($pqrsfs as $pqrsf) {
            $fecha1 = Carbon::now()->format('Y-m-d');
            $fecha2 = Carbon::parse($pqrsf->created_at->format('Y-m-d'));
            $diasDiferencia = $fecha2->diffInDays($fecha1);
            foreach ($this->holydays as $holyday) {
                $exFecha1 = explode('-', $fecha1);
                $exFecha2 = explode('-', $fecha2);
                $exHolyday = explode('-', $holyday);
                if(intval($exFecha2[0]) <= intval($exHolyday[0]) && intval($exFecha1[0]) >= intval($exHolyday[0])){
                    if(intval($exFecha2[1]) <= intval($exHolyday[1]) && intval($exFecha1[1]) >= intval($exHolyday[1])){
                        if(intval($exFecha2[2]) <= intval($exHolyday[2]) && intval($exFecha1[2]) >= intval($exHolyday[2])){
                            $diasDiferencia--;
                        }
                    }
                }
            }
            if ($diasDiferencia < 0){
                $diasDiferencia = 0;
            }
            $pqrsf['diasHabiles'] = $diasDiferencia;
        }

        return response()->json($pqrsfs, 201);
        }
    }

    public function solved(Request $request)
    {
        $permisos    = Auth::user()->permissions;
        $permisoname = [];
        foreach ($permisos as $permiso) {
            array_push($permisoname, $permiso->name);
        }
        $adminpqrsf = array_search("Admin Pqrsf", $permisoname);
        $admin        = var_export($adminpqrsf, true);

        $user = Auth::user()->id;

        if ($admin == "false") {
            $pqrsfs = Pqrsf::select(['Pqrsfs.Email', 'Pqrsfs.Afec_numdoc as doc','Pqrsfs.Canal',
            'pqrsfs.id','Pacientes.Num_Doc as cc', 'Pacientes.Primer_Nom as Nombre', 'pqrsfs.created_at',
            'pqrsfs.Tiposolicitud as Solicitud', 'Sedeproveedores.Nombre as IPS', 'Pacientes.Primer_Ape as Apellido',
            'pqrsfs.Telefono as Telefono', 'pqrsfs.Descripcion', 'pqrsfs.Reabierta', 'pqrsfs.Priorizacion',
            'pqrsfs.Atr_calidad', 'pqrsfs.Tiposolicitud', 'Pacientes.id as Paciente_id', 'Pacientes.Edad_Cumplida',
            'Estados.Nombre as Estado', 'pqrsfs.updated_at'])
            ->leftjoin('Pacientes', 'Pqrsfs.Paciente_id', 'Pacientes.id')
            ->leftjoin('Sedeproveedores', 'Pacientes.IPS', 'Sedeproveedores.id')
            ->join('Estados', 'pqrsfs.Estado_id', 'Estados.id')
            ->join('gestions_pqrsf', 'gestions_pqrsf.Pqrsf_id', 'Pqrsfs.id')
            ->with(['Subcategoriaspqrsf' => function ($query) {
                $query->select('Subcategoriaspqrsf.Subcategoria_id', 'Subcategoriaspqrsf.Pqrsf_id', 'sub.Nombre')
                    ->join('Subcategorias as sub', 'Subcategoriaspqrsf.Subcategoria_id', 'sub.id')
                    ->get();
            }])
            ->with(['Gestion_pqrsfs' => function ($query) {
                $query->select('gestions_pqrsf.id', 'gestions_pqrsf.Pqrsf_id', 'gestions_pqrsf.Tipo_id', 'gestions_pqrsf.Motivo',
                'users.name', 'users.apellido', 'gestions_pqrsf.created_at', 'gestions_pqrsf.Responsable')
                    ->leftjoin('users', 'User_id', 'users.id')
                    ->with(['Adjuntos_pqrsf' => function ($query) {
                        $query->select('Ruta', 'Gestion_id')
                            ->get();
                    }])
                    ->get();
            }])
            ->with(['Permisospqrsf' => function ($query) {
                $query->select('Pqrsf_id', 'Permission_id', 'pe.name')
                    ->join('permissions as pe', 'Permission_id', 'pe.id')
                    ->get();
            }])
            ->where('gestions_pqrsf.User_id', $user)
            ->where(function($query) use ($request){
                $query->where('Pacientes.Num_Doc', $request->buscar);
                $query->orWhere('pqrsfs.id', $request->buscar);
            })
            ->whereNotIn('pqrsfs.Canal', ['Web', 'Supersalud'])
            ->whereIn('Pqrsfs.Estado_id', [13, 26])
            ->distinct()
            ->get();

            return response()->json($pqrsfs, 201);
        }else{
            $pqrsfs = Pqrsf::select(['Pqrsfs.Email', 'Pqrsfs.Afec_numdoc as doc','Pqrsfs.Canal',
            'pqrsfs.id','Pacientes.Num_Doc as cc', 'Pacientes.Primer_Nom as Nombre', 'pqrsfs.created_at',
            'pqrsfs.Tiposolicitud as Solicitud', 'Sedeproveedores.Nombre as IPS', 'Pacientes.Primer_Ape as Apellido',
            'pqrsfs.Telefono as Telefono', 'pqrsfs.Descripcion', 'pqrsfs.Reabierta', 'pqrsfs.Priorizacion',
            'pqrsfs.Atr_calidad', 'pqrsfs.Tiposolicitud', 'Pacientes.id as Paciente_id', 'Pacientes.Edad_Cumplida',
            'Estados.Nombre as Estado', 'pqrsfs.updated_at'])
            ->leftjoin('Pacientes', 'Pqrsfs.Paciente_id', 'Pacientes.id')
            ->leftjoin('Sedeproveedores', 'Pacientes.IPS', 'Sedeproveedores.id')
            ->join('Estados', 'pqrsfs.Estado_id', 'Estados.id')
            ->join('gestions_pqrsf', 'gestions_pqrsf.Pqrsf_id', 'Pqrsfs.id')
            ->with(['Subcategoriaspqrsf' => function ($query) {
                $query->select('Subcategoriaspqrsf.Subcategoria_id', 'Subcategoriaspqrsf.Pqrsf_id', 'sub.Nombre')
                    ->join('Subcategorias as sub', 'Subcategoriaspqrsf.Subcategoria_id', 'sub.id')
                    ->get();
            }])
            ->with(['Gestion_pqrsfs' => function ($query) {
                $query->select('gestions_pqrsf.id', 'gestions_pqrsf.Pqrsf_id', 'gestions_pqrsf.Tipo_id', 'gestions_pqrsf.Motivo',
                'users.name', 'users.apellido', 'gestions_pqrsf.created_at', 'gestions_pqrsf.Responsable')
                    ->leftjoin('users', 'User_id', 'users.id')
                    ->with(['Adjuntos_pqrsf' => function ($query) {
                        $query->select('Ruta', 'Gestion_id')
                            ->get();
                    }])
                    ->get();
            }])
            ->with(['Permisospqrsf' => function ($query) {
                $query->select('Pqrsf_id', 'Permission_id', 'pe.name')
                    ->join('permissions as pe', 'Permission_id', 'pe.id')
                    ->get();
            }])
            ->where(function($query) use ($request){
                $query->where('Pacientes.Num_Doc', $request->buscar);
                $query->orWhere('pqrsfs.id', $request->buscar);
            })
            ->whereNotIn('pqrsfs.Canal', ['Web', 'Supersalud'])
            ->whereIn('Pqrsfs.Estado_id', [13, 26])
            ->distinct()
            ->get();

            return response()->json($pqrsfs, 201);
        }
    }

    public function countPqrsfs()
    {
        $permisos    = Auth::user()->permissions;
        $permisoname = [];
        foreach ($permisos as $permiso) {
            array_push($permisoname, $permiso->name);
        }
        $adminpqrsf = array_search("Admin Pqrsf", $permisoname);
        $admin        = var_export($adminpqrsf, true);

        $user = Auth::user()->id;


        if ($admin == "false") {
            $pendientes =  Gestions_pqrsf::join('pqrsfs as pq', 'gestions_pqrsf.Pqrsf_id', 'pq.id')
            ->where('pq.Estado_id', 18)
            ->where('gestions_pqrsf.User_id', $user)
            ->whereNotIn('pq.Canal', ['Web', 'Supersalud'])
            ->groupBy('gestions_pqrsf.Tipo_id')
            ->count();
        }else{
            $pendientes =  Gestions_pqrsf::join('pqrsfs as pq', 'gestions_pqrsf.Pqrsf_id', 'pq.id')
            ->where('pq.Estado_id', 18)
            ->whereNotIn('pq.Canal', ['Web', 'Supersalud'])
            ->groupBy('gestions_pqrsf.Tipo_id')
            ->count();
        }

        if ($admin == "false") {
            $asignadas =  Gestions_pqrsf::join('pqrsfs as pq', 'gestions_pqrsf.Pqrsf_id', 'pq.id')
            ->whereIn('pq.Estado_id', [5, 24, 11])
            ->where('gestions_pqrsf.User_id', $user)
            ->whereNotIn('pq.Canal', ['Web', 'Supersalud'])
            ->groupBy('gestions_pqrsf.Tipo_id')
            ->count();
        }else{
            $asignadas =  Gestions_pqrsf::join('pqrsfs as pq', 'gestions_pqrsf.Pqrsf_id', 'pq.id')
            ->whereIn('pq.Estado_id', [5, 24, 11])
            ->whereNotIn('pq.Canal', ['Web', 'Supersalud'])
            ->groupBy('gestions_pqrsf.Tipo_id')
            ->count();
        }

        if ($admin == "false") {
            $pre_solucionadas =  Gestions_pqrsf::join('pqrsfs as pq', 'gestions_pqrsf.Pqrsf_id', 'pq.id')
            ->where('pq.Estado_id', 19)
            ->where('gestions_pqrsf.User_id', $user)
            ->where('gestions_pqrsf.Tipo_id', 3)
            ->whereNotIn('pq.Canal', ['Web', 'Supersalud'])
            ->groupBy('gestions_pqrsf.Tipo_id')
            ->count();
        }else{
            $pre_solucionadas =  Gestions_pqrsf::join('pqrsfs as pq', 'gestions_pqrsf.Pqrsf_id', 'pq.id')
            ->where('pq.Estado_id', 19)
            ->whereNotIn('pq.Canal', ['Web', 'Supersalud'])
            ->groupBy('gestions_pqrsf.Tipo_id')
            ->count();
        }


        if ($admin == "false") {
            $solucionadas =  Gestions_pqrsf::join('pqrsfs as pq', 'gestions_pqrsf.Pqrsf_id', 'pq.id')
            ->whereIn('pq.Estado_id', [13, 26])
            ->where('gestions_pqrsf.User_id', $user)
            ->whereNotIn('pq.Canal', ['Web', 'Supersalud'])
            ->groupBy('gestions_pqrsf.Tipo_id')
            ->count();
        }else{
            $solucionadas =  Gestions_pqrsf::join('pqrsfs as pq', 'gestions_pqrsf.Pqrsf_id', 'pq.id')
            ->whereIn('pq.Estado_id', [13, 26])
            ->whereNotIn('pq.Canal', ['Web', 'Supersalud'])
            ->groupBy('gestions_pqrsf.Tipo_id')
            ->count();
        }

        return response()->json(['Pendientes' => $pendientes,
                                 'Asignadas' => $asignadas,
                                 'Pre_solucionadas' => $pre_solucionadas,
                                 'Solucionadas' => $solucionadas
                                ], 201);
    }

}


