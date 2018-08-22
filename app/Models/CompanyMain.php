<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CompanyMain extends Model
{
    protected $table = 'company_main';

    protected $fillable = ['enterprise_id', 'name', 'contact', 'stock', 'worth'];
}
