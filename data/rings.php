<?php
class Ring
{
    public $name;
    public $cost;
    private $subselect_func;
    
    function __construct($name, $cost, $subselect_func = '')
    {
        $this->name = $name;
        $this->cost = $cost;
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

function energy_ring()
{
    global $energy_elemental;
    return arr($energy_elemental);
}

$rings = [
    new Ring('prisoner\'s dungeon ring', 250),
    new Ring('ring of arcane signets', 1000),
    new Ring('ring of spell knowledge I', 1500),
    new Ring('ring of the grasping grave', 2000),
    new Ring('ring of feather falling', 2200),
    new Ring('ring of climbing', 2500),
    new Ring('ring of jumping', 2500),
    new Ring('ring of sustenance', 2500),
    new Ring('ring of swimming', 2500),
    new Ring('ring of ferocious action', 3000),
    new Ring('ring of counterspells', 4000),
    new Ring('ring of maniacal devices', 5000),
    new Ring('ring of rat fangs', 5000),
    new Ring('ring of sacred mistletoe', 6000),
    new Ring('ring of spell knowledge II', 6000),
    new Ring('ring of swarming stabs', 6000),
    new Ring('ring of grit mastery', 6840),
    new Ring('ring of forcefangs', 8000),
    new Ring('ring of mind shielding', 8000),
    new Ring('ring of strength sapping', 8000),
    new Ring('ring of force shield', 8500),
    new Ring('ring of the ram', 8600),
    new Ring('scholar\'s ring', 8700),
    new Ring('improved ring of climbing', 10000),
    new Ring('ring of curing', 10000),
    new Ring('ring of foe focus', 10000),
    new Ring('improved ring of jumping', 10000),
    new Ring('ring of ki mastery', 10000),
    new Ring('lesser ring of revelation', 10000),
    new Ring('improved ring of swimming', 10000),
    new Ring('ring of animal friendship', 10800),
    new Ring('ring of transposition', 10800),
    new Ring('ring of tactical precision', 11000),
    new Ring('ring of the sophisticate', 11000),
    new Ring('decoy ring', 12000),
    new Ring('ring of craft magic', 12000),
    new Ring('ring of ectoplasmic invigoration', 12000),
    new Ring('minor ring of energy resistance', 12000, 'energy_ring'),
    new Ring('ring of the troglodyte', 12000),
    new Ring('steelhand circle', 12000),
    new Ring('ring of chameleon power', 12700),
    new Ring('ring of spell knowledge III', 13500),
    new Ring('ring of the sea strider', 14000),
    new Ring('ring of retribution', 15000),
    new Ring('ring of water walking', 15000),
    new Ring('jailer\'s dungeon ring', 16000),
    new Ring('greater ring of revelation', 16000),
    new Ring('minor ring of inner fortitude', 18000),
    new Ring('minor ring of spell storing', 18000), // TODO: 3 levels of spells
    new Ring('ring of energy shroud', 19500, 'energy_ring'),
    new Ring('ring of arcane mastery', 20000),
    new Ring('ring of invisibility', 20000),
    new Ring('ring of wizardry I', 20000),
    new Ring('superior ring of revelation', 24000),
    new Ring('ring of spell knowledge IV', 24000),
    new Ring('ring of evasion', 25000),
    new Ring('ring of x-ray vision', 25000),
    new Ring('ring of blinking', 27000),
    new Ring('major ring of energy resistance', 28000, 'energy_ring'),
    new Ring('ring of the ecclesiarch', 28500),
    new Ring('ring of return', 33600),
    new Ring('ring of freedom of movement', 40000),
    new Ring('ring of wizardry II', 40000),
    new Ring('major ring of inner fortitude', 42000),
    new Ring('greater ring of energy resistance', 44000, 'energy_ring'),
    new Ring('ring of delayed doom', 45000),
    new Ring('ring of friend shield', 50000),
    new Ring('ring of shooting stars', 50000),
    new Ring('ring of spell storing', 50000), // TODO: 5 levels of spells
    new Ring('ring of continuation', 56000),
    new Ring('greater ring of inner fortitude', 66000),
    new Ring('ring of wizardry III', 70000),
    new Ring('spirtualist rings', 70000),
    new Ring('ring of telekinesis', 75000),
    new Ring('ring of regeneration', 90000),
    new Ring('ring of spell turning', 100000),
    new Ring('ring of wizardry IV', 100000),
    new Ring('ring of three wishes', 120000),
    new Ring('ring of djinni calling', 125000),
    new Ring('ring of elemental command', 200000),
    new Ring('major ring of spell storing', 200000) // TODO: 10 levels of spells
];
?>
