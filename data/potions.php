<?php

class Potion
{
    public $level;
    public $name;
    public $cost;
    private $subselect_func;
    
    function __construct($level, $name, $cost = 0, $subselect_func = '')
    {
        $this->level = $level;
        $this->name = $name;
        $this->subselect_func = $subselect_func;
        
        if ($cost === 0)
        {
            switch ($level)
            {
                case 1: $this->cost = 50; break;
                case 2: $this->cost = 300; break;
                case 3: $this->cost = 750; break;
                default: $this->cost = 25; break;
            }
        }
        else
        {
            $this->cost = $cost;
        }
    }
    
    function subselect()
    {
        if ($this->subselect_func != '')
        {
            return call_user_func($this->subselect_func);
        }
        return '';
    }
}

function energy_potion()
{
    global $energy;
    return arr($energy);
}

$potions = [];

$potions[0] = [
    new Potion(0, 'arcane mark'),
    new Potion(0, 'guidance'),
    new Potion(0, 'light'),
    new Potion(0, 'purify food and drink'),
    new Potion(0, 'resistance'),
    new Potion(0, 'stabilize'),
    new Potion(0, 'virtue')
];

$potions[1] = [
    new Potion(1, 'animate rope'),
    new Potion(1, 'bless weapon'),
    new Potion(1, 'cure light wounds'),
    new Potion(1, 'endure elements'),
    new Potion(1, 'enlarge person'),
    new Potion(1, 'erase'),
    new Potion(1, 'goodberry'),
    new Potion(1, 'grease'),
    new Potion(1, 'hide from animals'),
    new Potion(1, 'hide from undead'),
    new Potion(1, 'hold portal'),
    new Potion(1, 'jump'),
    new Potion(1, 'mage armor'),
    new Potion(1, 'magic fang'),
    new Potion(1, 'magic stone'),
    new Potion(1, 'magic weapon'),
    new Potion(1, 'pass without trace'),
    new Potion(1, 'protection from chaos'),
    new Potion(1, 'protection from evil'),
    new Potion(1, 'protection from good'),
    new Potion(1, 'protection from law'),
    new Potion(1, 'reduce person'),
    new Potion(1, 'remove fear'),
    new Potion(1, 'sanctuary'),
    new Potion(1, 'shield of faith'),
    new Potion(1, 'shillelagh')
];

$potions[2] = [
    new Potion(2, 'aid'),
    new Potion(2, 'align weapon'),
    new Potion(2, 'arcane lock'),
    new Potion(2, 'barkskin'),
    new Potion(2, 'bear\'s endurance'),
    new Potion(2, 'blur'),
    new Potion(2, 'bull\'s strength'),
    new Potion(2, 'cat\'s grace'),
    new Potion(2, 'cure moderate wounds'),
    new Potion(2, 'darkness'),
    new Potion(2, 'darkvision'),
    new Potion(2, 'delay poison'),
    new Potion(2, 'eagle\'s splendor'),
    new Potion(2, 'fox\'s cunning'),
    new Potion(2, 'gentle repose'),
    new Potion(2, 'invisibility'),
    new Potion(2, 'levitate'),
    new Potion(2, 'make whole'),
    new Potion(2, 'obscure object'),
    new Potion(2, 'owl\'s wisdom'),
    new Potion(2, 'protection from arrows'),
    new Potion(2, 'reduce animal'),
    new Potion(2, 'remove paralysis'),
    new Potion(2, 'resist energy', 0, 'energy_potion'),
    new Potion(2, 'rope trick'),
    new Potion(2, 'shatter'),
    new Potion(2, 'spider climb'),
    new Potion(2, 'status'),
    new Potion(2, 'undetectable alignment'),
    new Potion(2, 'warp wood'),
    new Potion(2, 'wood shape'),
    new Potion(2, 'continual flame', 350)
];

$potions[3] = [
    new Potion(3, 'cure serious wounds'),
    new Potion(3, 'daylight'),
    new Potion(3, 'dispel magic'),
    new Potion(3, 'displacement'),
    new Potion(3, 'fire trap'),
    new Potion(3, 'flame arrow'),
    new Potion(3, 'fly'),
    new Potion(3, 'gaseous form'),
    new Potion(3, 'good hope'),
    new Potion(3, 'haste'),
    new Potion(3, 'heroism'),
    new Potion(3, 'keen edge'),
    new Potion(3, 'greater magic fang'),
    new Potion(3, 'magic vestment'),
    new Potion(3, 'neutralize poison'),
    new Potion(3, 'protection from energy', 0, 'energy_potion'),
    new Potion(3, 'rage'),
    new Potion(3, 'remove blindness/deafness'),
    new Potion(3, 'remove curse'),
    new Potion(3, 'remove disease'),
    new Potion(3, 'shrink item'),
    new Potion(3, 'stone shape'),
    new Potion(3, 'tongues'),
    new Potion(3, 'water breathing'),
    new Potion(3, 'water walk'),
    new Potion(3, 'nondetection', 800)  
];
?>