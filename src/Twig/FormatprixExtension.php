<?php

namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;

class FormatprixExtension extends AbstractExtension
{
    public function getFilters(): array
    {
        return [
            // If your filter generates SAFE HTML, you should add a third
            // parameter: ['is_safe' => ['html']]
            // Reference: https://twig.symfony.com/doc/2.x/advanced.html#automatic-escaping
            new TwigFilter('price', [$this, 'formatPrice']),
            new TwigFilter('badge', [$this, 'displayBadge'],['is_safe'  =>  ['html']]),
            new TwigFilter('star', [$this, 'displayStar'],['is_safe'  =>  ['html']]),
    ];
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('function_name', [$this, 'doSomething']),
        ];
    }

    public function formatPrice(float $price):string
    {
        return number_format( $price, 2, ',' , ' ' ) . '€';
    }
    public function displayBadge(int $place): string
    {
            if($place >= 30){
                return '<span class="badge rounded-pill bg-success">Disponible</span>';
            }
            elseif($place >= 10 && $place < 30 ){
                return '<span class="badge rounded-pill bg-warning">Disponible</span>';
            }
            elseif($place >= 1 && $place < 10){
                return '<span class="badge rounded-pill bg-danger">Disponible</span>';
            }
            else{
            return '<span class="badge rounded-pill bg-secondary">Rupture</span>';
            } 
    }
    
    public function displayStar(int $note): string
    {
            if($note >= 3){
                return '<span class="badge rounded-pill bg-success" style="font-size:3rem; margin-left:1rem;"><i class="far fa-thumbs-up"></i></span>';
            }
            elseif($note >= 2 && $note < 3 ){
                return '<span class="badge rounded-pill bg-warning" style="font-size:3rem; margin-left:1rem;"><i class="far fa-thumbs-up"></i></span>';
            }
            else{
            return '<span class="badge rounded-pill bg-danger" style="font-size:3rem; margin-left:1rem;"><i class="far fa-thumbs-down"></i></span>';
            } 
    }
}

// si voyage affaire 
//     alors si classe affaire <= 0 
//             btn voir plus ou reserver bloquer
// si
//  alors si class eco <= 0 
//          btn voir plus ou reserver bloquer
// sinon 
