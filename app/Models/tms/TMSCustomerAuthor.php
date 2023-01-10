<?php

namespace App\Models\tms;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TMSCustomerAuthor extends Model
{
    use SoftDeletes;

    protected $table = "tms_customer_authors";

    protected $fillable = [
        'customer_id', 'name', 'title', 'phone', 'email'
    ];


    public static function scopeCustomerId($query, $customerId)
    {
        return $query->where("customer_id", $customerId);
    }

    public static function scopeName($query, $name)
    {
        return $query->where("name", $name);
    }

    public static function getCustomerAuthors($customerId)
    {
        return self::customerId($customerId)->get();
    }

    public static function addAuthor($customerId, $name, $title, $phone, $email)
    {
        $author = self::customerId($customerId)->name($name)->first();
        if ($author)
            return null;

        $author = new self();
        $author->customer_id = $customerId;
        $author->name = strtoupper($name);
        $author->title = strtoupper($title);
        $author->phone = $phone;
        $author->email = strtolower($email);
        $author->save();
        return $author;
    }

    public static function updateAuthor($id, $customerId, $name, $title, $phone, $email)
    {
        $author = self::find($id);
        if (is_null($author))
            return null;

        $author->customer_id = $customerId;
        $author->name = strtoupper($name);
        $author->title = strtoupper($title);
        $author->phone = $phone;
        $author->email = strtolower($email);
        $author->save();
        return $author;
    }

    public static function deleteAuthor($id)
    {
        $author = self::find($id);
        if (is_null($author))
            return false;

        $author->delete();
        return true;
    }
}
