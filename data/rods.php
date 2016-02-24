<?php

class Rod
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

function metamagic_plus_1()
{
    global $metamagic;
    return arr($metamagic[1]);
}

function metamagic_plus_2()
{
    global $metamagic;
    return arr($metamagic[2]);
}

function metamagic_plus_3()
{
    global $metamagic;
    return arr($metamagic[3]);
}

$rods = [
    new Rod('lesser metamagic rod (merciful spell)', 1500),
    new Rod('lesser metamagic rod', 3000, 'metamagic_plus_1'),
    new Rod('immovable rod', 5000),
    new Rod('rod of thunderous force', 5400),
    new Rod('metamagic rod (merciful spell)', 5500),
    new Rod('rod of ice', 8500),
    new Rod('lesser metamagic rod', 9000, 'metamagic_plus_2'),
    new Rod('rod of metal and mineral detection', 10500),
    new Rod('metamagic rod', 11000, 'metamagic_plus_1'),
    new Rod('rod of cancellation', 11000),
    new Rod('conduit rod', 12000),
    new Rod('grounding rod', 12000),
    new Rod('rod of the wayang', 12000),
    new Rod('rod of wonder', 12000),
    new Rod('greater metamagic rod (merciful spell)', 12250),
    new Rod('rod of the python', 13000),
    new Rod('trap-stealer\'s rod', 13000),
    new Rod('lesser metamagic rod', 14000, 'metamagic_plus_3'),
    new Rod('rod of balance', 15000),
    new Rod('rod of escape', 15000),
    new Rod('rod of flame extinguishing', 15000),
    new Rod('rod of ruin', 16000),
    new Rod('sapling rod', 16650),
    new Rod('rod of beguiling', 18000),
    new Rod('rod of nettles', 18000),
    new Rod('rod of the viper', 19000),
    new Rod('suzerain scepter', 20000),
    new Rod('fiery nimbus rod', 22305),
    new Rod('rod of enemy detection', 23500),
    new Rod('greater metamagic rod', 24500, 'metamagic_plus_1'),
    new Rod('rod of splendor', 25000),
    new Rod('rod of withering', 25000),
    new Rod('earthbind rod', 26500),
    new Rod('rod of the aboleth', 29000),
    new Rod('liberator\'s rod', 30000),
    new Rod('metamagic rod', 32500, 'metamagic_plus_2'),
    new Rod('lesser metamagic rod (quicken spell)', 35000),
    new Rod('rod of thunder and lightning', 33000),
    new Rod('rod of negation', 37000),
    new Rod('rod of steadfast resolve', 38305),
    new Rod('rod of absorption', 50000),
    new Rod('rod of flailing', 50000),
    new Rod('metamagic rod', 54000, 'metamagic_plus_3'),
    new Rod('rod of rulership', 60000),
    new Rod('rod of security', 61000),
    new Rod('rod of shadows', 64305),
    new Rod('rod of mind mastery', 67000),
    new Rod('rod of lordly might', 70000),
    new Rod('greater metamagic rod', 73000, 'metamagic_plus_2'),
    new Rod('scepter of heaven', 74000),
    new Rod('metamagic rod (quicken spell)', 75500),
    new Rod('rod of dwarven might', 80000),
    new Rod('rod of alertness', 85000),
    new Rod('greater metamagic rod', 121500, 'metamagic_plus_3'),
    new Rod('greater metamagic rod (quicken spell)', 170000)
];

$metamagic = [];

$metamagic[1] = [
    'bouncing spell',
    'disruptive spell',
    'ectoplasmic spell',
    'elemental spell',
    'enlarge spell',
    'extend spell',
    'flaring spell',
    'focused spell',
    'intensified spell',
    'lingering spell',
    'piercing spell',
    'reach spell',
    'rime spell',
    'selective spell',
    'silent spell',
    'toppling spell'  
];

$metamagic[2] = [
    'burning spell',
    'concussive spell',
    'empower spell',
    'persistent spell',
    'sickening spell',
    'thanatopic spell',
    'threnodic spell',
    'thundering spell'
];

$metamagic[3] = [
    'dazing spell',
    'echoing spell',
    'maximize spell',
    'widen spell'  
];
?>
