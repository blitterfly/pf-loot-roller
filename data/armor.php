<?php
const L = 0;
const M = 1;
const H = 2;

class Armor
{
    public $name;
    public $cost;
    public $ac;
    public $type;
    public $material;
    
    function __construct($name, $cost, $ac, $type = M, $material = Metal)
    {
        $this->name = $name;
        $this->cost = $cost;
        $this->ac = $ac;
        $this->type = $type;
        $this->material = $material;
    }
}

class ArmorEnh
{
    public $enh;
    public $cost;
    public $name;
    private $subselect_func;
   
    function __construct($enh, $name, $cost = 0, $subselect_func = '')
    {
        $this->enh = $enh;
        $this->cost = $cost;
        $this->name = $name;
        $this->subselect_func = $subselect_func;
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

function energy_resist()
{
    global $energy;
    return arr($energy);
}

$armors = [
    new Armor('padded armor', 155, 1, L, None),
    new Armor('leather armor', 160, 2, L, None),
    new Armor('bulette leather armor', 200, 3, L, None),
    new Armor('studded leather armor', 175, 3, L, None),
    new Armor('chain shirt', 250, 4, L),
    new Armor('hide armor', 165, 4, M, Hide),
    new Armor('scale mail', 200, 5),
    new Armor('chainmail', 300, 6),
    new Armor('breastplate', 350, 6, M, Hide | Metal),
    new Armor('splint mail', 350, 7, H),
    new Armor('banded mail', 400, 7, H, Hide | Metal),
    new Armor('half-plate', 750, 8, H, Hide | Metal),
    new Armor('bulette full plate', 16500, 9, H, None),
    new Armor('full plate', 1650, 9, H, Hide | Metal),
    new Armor('haramaki', 153, 1, L),
    new Armor('silken ceremonial armor', 180, 1, L, None),
    new Armor('lamellar cuirass', 165, 2, L, Hide),
    new Armor('leather lamellar', 210, 4, L, Hide),
    new Armor('do-maru', 350, 5, M, Hide | Metal),
    new Armor('kikko armor', 400, 5),
    new Armor('horn lamellar', 250, 5, M, Hide),
    new Armor('four-mirror armor', 275, 6),
    new Armor('steel lamellar', 300, 6),
    new Armor('mountain pattern armor', 400, 6),
    new Armor('kusari gusoku', 500, 7, H),
    new Armor('iron lamellar', 350, 7, H),
    new Armor('stone coat lamellar', 650, 8, H),
    new Armor('tatami-do', 1150, 7, H),
    new Armor('o-yoroi', 1850, 8, H),
    new Armor('heavy weapon harness', 9000, 1, L, None),
    new Armor('brown scatterlight suit', 100, 1, L, None),
    new Armor('chameleon suit', 15000, 2, L, None),
    new Armor('black scatterlight suit', 150, 2, L, None),
    new Armor('inssuit', 19250, 3, L, None),
    new Armor('deep diving suit', 26000, 3, L, None),
    new Armor('white scatterlight suit', 200, 3, L, None),
    new Armor('smart armor', 16500, 4, L, None),
    new Armor('gray scatterlight suit', 700, 4, L, None),
    new Armor('green scatterlight suit', 1000, 5, L, None),
    new Armor('red scatterlight suit', 1400, 6, L, None),
    new Armor('blue scatterlight suit', 3600, 7, L, None),
    new Armor('orange scatterlight suit', 8000, 8, L, None),
    new Armor('prismatic scatterlight suit', 12000, 9, L, None),
    new Armor('gravity suit', 40000, 5, L, None),
    new Armor('panic suit', 2000, 2, M, None),
    new Armor('HEV suit', 61000, 4, M, None),
    new Armor('nanite ablative armor', 10000, 4, M, None),
    new Armor('spacesuit', 90000, 7, H, None),
    new Armor('bracers of armor', 151, 0, None, None)
];

$shields = [
    new Armor('buckler', 165, 1, None, Wood | Metal),
    new Armor('light wooden shield', 153, 1, None, Wood),
    new Armor('light metal shield', 159, 1, None, Metal),
    new Armor('heavy wooden shield', 157, 2, None, Wood),
    new Armor('heavy metal shield', 170, 2, None, Metal),
    new Armor('tower shield', 180, 4, None, Wood)
];

$armorenh_base = [
    new ArmorEnh(0, 'poison-resistant', 2250),
    new ArmorEnh(1, 'defiant'),
    new ArmorEnh(1, 'light fortification'),
    new ArmorEnh(1, 'grinding'),
    new ArmorEnh(1, 'impervious'),
    new ArmorEnh(1, 'mirrored'),
    new ArmorEnh(2, 'spell resistance (13)'),
    new ArmorEnh(0, 'hosteling', 7500),
    new ArmorEnh(0, 'radiant', 7500),
    new ArmorEnh(3, 'moderate fortification'),
    new ArmorEnh(3, 'ghost touch'),
    new ArmorEnh(3, 'spell resistance (15)'),
    new ArmorEnh(3, 'wild'),
    new ArmorEnh(0, 'energy resistance', 18000, 'energy_resist'),
    new ArmorEnh(4, 'spell resistance (17)'),
    new ArmorEnh(0, 'determination', 30000),
    new ArmorEnh(0, 'improved energy resistance', 42000, 'energy_resist'),
    new ArmorEnh(0, 'greater energy resistance', 66000, 'energy_resist'),
    new ArmorEnh(0, 'undead controlling', 49000),
    new ArmorEnh(5, 'heavy fortification'),
    new ArmorEnh(5, 'spell resistance (19)') 
];

$armorenh = array_merge($armorenh_base, [
    new ArmorEnh(0, 'benevolent', 2000),
    new ArmorEnh(1, 'balanced'),
    new ArmorEnh(1, 'bitter'),
    new ArmorEnh(1, 'bolstering'),
    new ArmorEnh(1, 'brawling'),
    new ArmorEnh(1, 'champion'),
    new ArmorEnh(1, 'dastard'),
    new ArmorEnh(1, 'deathless'),
    new ArmorEnh(1, 'spell storing'),
    new ArmorEnh(1, 'stanching'),
    new ArmorEnh(1, 'warding'),
    new ArmorEnh(0, 'glamered', 2700),
    new ArmorEnh(0, 'jousting', 3750),
    new ArmorEnh(0, 'shadow', 3750),
    new ArmorEnh(0, 'slick', 3750),
    new ArmorEnh(0, 'expeditious', 4000),
    new ArmorEnh(0, 'creeping', 5000),
    new ArmorEnh(0, 'rallying', 5000),
    new ArmorEnh(0, 'adhesive', 7000),
    new ArmorEnh(0, 'delving', 10000),
    new ArmorEnh(0, 'putrid', 10000),
    new ArmorEnh(3, 'invulnerability'),
    new ArmorEnh(3, 'titanic'),
    new ArmorEnh(0, 'harmonizing', 15000),
    new ArmorEnh(0, 'improved shadow', 15000),
    new ArmorEnh(0, 'improved slick', 15000),
    new ArmorEnh(0, 'martyring', 18000),
    new ArmorEnh(0, 'righteous', 27000),
    new ArmorEnh(0, 'unbound', 27000),
    new ArmorEnh(0, 'unrighteous', 27000),
    new ArmorEnh(0, 'vigilant', 27000),
    new ArmorEnh(0, 'greater shadow', 33750),
    new ArmorEnh(0, 'greater slick', 33750),
    new ArmorEnh(0, 'etherealness', 49000),
]);

$shieldenh = array_merge($armorenh_base, [
    new ArmorEnh(1, 'arrow catching'),
    new ArmorEnh(1, 'bashing'),
    new ArmorEnh(1, 'blinding'),
    new ArmorEnh(1, 'clangorous'),
    new ArmorEnh(1, 'ramming'),
    new ArmorEnh(0, 'rallying', 5000),
    new ArmorEnh(0, 'wyrmsbreath', 5000),
    new ArmorEnh(2, 'animated'),
    new ArmorEnh(2, 'arrow deflection'),
    new ArmorEnh(2, 'merging'),
    new ArmorEnh(5, 'reflecting')
]);
?>
