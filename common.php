<?php
const Melee = 0;
const Ranged = 1;

const None = 0;
const Metal = 1;
const Wood = 2;
const Hide = 4;

const NBSP = "\xc2\xa0"; // UTF-8

function arr(&$array)
{
    if (is_array($array))
        return $array[array_rand($array)];
    return NULL;    
}

function bit($value, $b)
{
    return ($value & $b) === $b;
}

function filter_by_cost(&$items, $floor, $ceiling)
{
    return array_filter($items, function($v, $k) use ($floor, $ceiling) {
        return inr($v->cost, $floor, $ceiling); 
    }, ARRAY_FILTER_USE_BOTH);
}

function item_rarity($enh, $cost)
{
    global $wealth;
    if ($enh === 0)
    {
        foreach ($wealth as $k => $v)
        {
            if ($v > $cost)
            {
                if (inr($k, 1, 3))
                    $enh = 1;
                else if (inr($k, 4, 5))
                    $enh = 2;
                else if (inr($k, 6, 8))
                    $enh = 3;
                else if (inr($k, 9, 12))
                    $enh = 4;
                else if (inr($k, 13, 15))
                    $enh = 5;
                else
                    $enh = 6;
                break;
            }
        }
    }
    switch ($enh)
    {
        case 1: return 'fine';
        case 2: return 'uncommon';
        case 3: return 'rare';
        case 4: return 'exotic';
        case 5: return 'ascended';
        case 6: return 'legendary';
        default: return 'basic';
    }
}

function glitch()
{
    $entry = new ItemEntry();
    $entry->name = uniqid('', true);
    $entry->desc = '????';
    $entry->cost = rand(1, 3);
    $entry->icon = 'glitch';
    $t = rand(1, 3);
    for ($i = 0; $i < $t; $i++)
    {
        array_push($entry->tags, substr(md5(uniqid('', true)), 0, rand(5, 12)));
    }
    return $entry;
}

function inr($value, $min, $max)
{
    return $value >= $min && $value <= $max;
}

function makeopt($val, $txt, $selected = FALSE)
{
    echo '<option value="' . $val . '"';
    if ($selected)
        echo ' selected';
    echo '>' . $txt . "</option>\n";
}

function schecked($checked = FALSE)
{
    if ($checked)
        echo 'checked';
}

function to_ordinal($i)
{
    switch ($i % 10)
    {
        case 0: return $i . '';
        case 1: return $i . 'st';
        case 2: return $i . 'nd';
        case 3: return $i . 'rd';
        default: return $i . 'th';
    }
}

class ItemEntry
{
    public $name;
    public $desc;
    public $cost;
    public $enh;
    public $tags;
    public $icon;
    
    function __construct()
    {
        $this->name = '';
        $this->desc = '';
        $this->cost = 0;
        $this->enh = 0;
        $this->tags = [];
    }
}

$abilities_p = [
    'Strength',
    'Dexterity',
    'Constitution'
];

$abilities_m = [
    'Intelligence',
    'Wisdom',
    'Charisma'
];

$abilities = array_merge($abilities_p, $abilities_m);

$humanoids = [
    'aquatic',
    'dwarf',
    'elf',
    'giant',
    'gnoll',
    'gnome',
    'goblinoid',
    'halfling',
    'human',
    'orc',
    'reptilian'
];

$outsiders = [
    'air',
    'chaotic',
    'earth',
    'evil',
    'fire',
    'good',
    'lawful',
    'native',
    'water'
];

$energy_elemental = [
    'acid',
    'cold',
    'electricity',
    'fire'
];

$energy_non_elemental = [
    'sonic'  
];

$energy = array_merge($energy_elemental, $energy_non_elemental);

$wealth = [
    1 => 100,
    2 => 1000,
    3 => 3000,
    4 => 6000,
    5 => 10500,
    6 => 16000,
    7 => 23500,
    8 => 33000,
    9 => 46000,
    10 => 62000,
    11 => 82000,
    12 => 108000,
    13 => 140000,
    14 => 185000,
    15 => 240000,
    16 => 315000,
    17 => 410000,
    18 => 530000,
    19 => 685000,
    20 => 880000
];
?>
