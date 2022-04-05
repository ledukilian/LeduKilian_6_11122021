<?php

namespace App\Services;

use App\Entity\Trick;
use Doctrine\Persistence\ManagerRegistry;

class Slug
{

    public static function generate(String $text)
    {
        $text = preg_replace('~[^\pL\d]+~u', '-', $text);
        $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
        $text = preg_replace('~[^-\w]+~', '', $text);
        $text = trim($text, '-');
        $text = preg_replace('~-+~', '-', $text);
        $text = strtolower($text);
        if (empty($text)) {
            return 'n-a';
        }
        $val = Slug::checkNext($text);
        if ($val==0) {
            return $text;
        } else {
            return $text.'-'.$val;
        }
    }

    public static function checkNext(String $slug)
    {
        // ????
        $doctrine = ManagerRegistry;
        return $doctrine->getRepository(Trick::class)->createQueryBuilder('t')
            ->select('count(t.id)')
            ->andWhere('t.slug = :slug')
            ->setParameter('slug', $slug)
            ->getQuery()
            ->getSingleScalarResult()
            ;
    }

}