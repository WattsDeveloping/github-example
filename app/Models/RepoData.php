<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RepoData extends Model
{
    protected $fillable = array('id', 'user_id', 'name', 'description','stargazers_count','html_url');
}
