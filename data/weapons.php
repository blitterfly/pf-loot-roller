<?php
const P = 1;
const B = 2;
const S = 4;
const F = 8;
const E = 16;

class Weapon
{
    public $type;
    public $dmg;
    public $material;
    public $name;
    public $cost;
    public $double;
    
    function __construct($name, $dmg, $cost, $type = Melee, $material = Metal, $double = false)
    {
        $this->name = $name;
        $this->dmg = $dmg;
        $this->cost = $cost;
        $this->type = $type;
        $this->material = $material;
        $this->double = $double;
    }
    
    function is_ammo()
    {
        return strpos($this->name, '(') !== FALSE;
    }
    
    function ammo_count()
    {
        if ($this->is_ammo())
        {
            return intval(
                substr($this->name,
                strpos($this->name, '(') + 1,
                strpos($this->name, ')') - strpos($this->name, '(') - 1)
            );
        }
        return 0;
    }
    
    function base_cost()
    {
        $bc = $this->cost - 300;
        if ($this->double)
            $bc -= 300;
        if ($bc < 1)
            $bc = 1;
        return $bc;
    }    
}

class WeaponEnh
{
    public $enh;
    public $cost;
    public $name;
    private $subselect_func;
    private $valid_func;
   
    function __construct($enh, $name, $cost = 0, $subselect_func = '', $valid_func = '')
    {
        $this->enh = $enh;
        $this->cost = $cost;
        $this->name = $name;
        $this->subselect_func = $subselect_func;
        $this->valid_func = $valid_func;
    }
    
    function subselect()
    {
        if ($this->subselect_func != '')
        {
            return call_user_func($this->subselect_func);
        }
        return '';
    }
    
    function is_valid($weapon)
    {
        if ($this->valid_func != '')
        {
            return call_user_func($this->valid_func, $weapon);
        }
        return true;
    }
}

function bane_table()
{
    global $humanoids, $outsiders;
    
    $r = rand(1, 100);
    if (inr($r, 1, 5))
        return 'aberrations';
    if (inr($r, 6, 9))
        return 'animals';
    if (inr($r, 10, 16))
        return 'constructs';
    if (inr($r, 17, 22))
        return 'dragons';
    if (inr($r, 23, 27))
        return 'fey';
    if (inr($r, 28, 60))
        return 'humanoids [' . arr($humanoids) . ']';
    if (inr($r, 61, 65))
        return 'magical beasts';
    if (inr($r, 66, 70))
        return 'monstrous humanoids';
    if (inr($r, 71, 72))
        return 'oozes';
    if (inr($r, 73, 88))
        return 'outsiders [' . arr($outsiders) . ']';
    if (inr($r, 89, 90))
        return 'plants';
    if (inr($r, 91, 98))
        return 'undead';
    if (inr($r, 99, 100))
        return 'vermin';
    return '? (' . $r . ')';
}

function adaptive_valid($weapon)
{
    return strpos($weapon->name, 'composite') !== FALSE;
}

function disruption_valid($weapon)
{
    return bit($weapon->dmg, B);
}

function dryload_valid($weapon)
{
    return strpos($weapon->name, 'cartridge') !== FALSE;
}

function endless_valid($weapon)
{
    return strpos($weapon->name, 'bow') !== FALSE;
}

function keen_valid($weapon)
{
    return bit($weapon->dmg, P) || bit($weapon->dmg, S);
}

function thrown_only_valid($weapon)
{
    return strpos($weapon->name, 'bow') === FALSE &&
        strpos($weapon->name, 'blowgun') === FALSE; // HACK: don't match bow/crossbow/blowgun?
}

function vorpal_valid($weapon)
{
    return bit($weapon->dmg, S);
}

$weapons_simple = [
    new Weapon('blowgun', P, 302, Ranged, None),
    new Weapon('blowgun darts (10)', P, 6, Ranged, Metal),
    new Weapon('club', B, 300, Melee, Wood),
    new Weapon('heavy crossbow', P, 350, Ranged, None),
    new Weapon('light crossbow', P, 335, Ranged, None),
    new Weapon('crossbow bolts (30)', P, 61, Ranged, Metal),
    new Weapon('dagger', P | S, 302),
    new Weapon('punching dagger', P, 302),
    new Weapon('dart', P, 300, Ranged, Metal),
    new Weapon('gauntlet', B, 302),
    new Weapon('spiked gauntlet', P, 305),
    new Weapon('javelin', P, 301, Ranged, Metal | Wood),
    new Weapon('longspear', P, 305, Melee, Metal | Wood),
    new Weapon('heavy mace', B, 312),
    new Weapon('light mace', B, 305),
    new Weapon('morningstar', B | P, 308),
    new Weapon('quarterstaff', B, 600, Melee, Wood, true),
    new Weapon('shortspear', P, 301, Melee, Metal | Wood),
    new Weapon('sickle', S, 306),
    new Weapon('sling', B, 300, Ranged, None),
    new Weapon('sling bullets (10)', B, 60, Ranged, Metal),
    new Weapon('spear', P, 302, Melee, Metal | Wood),
    new Weapon('hanbo', B, 301, Melee, Wood),
    new Weapon('amulet of mighty fists', None, 301, Melee, None)
];

$weapons_martial = [
    new Weapon('throwing axe', S, 308, Ranged),
    new Weapon('battleaxe', S, 310),
    new Weapon('falchion', S, 375),
    new Weapon('flail', B, 308),
    new Weapon('heavy flail', B, 315),
    new Weapon('glaive', S, 308),
    new Weapon('greataxe', S, 320),
    new Weapon('greatclub', B, 305, Melee, Wood),
    new Weapon('greatsword', S, 350),
    new Weapon('guisarme', S, 309),
    new Weapon('halberd', P | S, 310),
    new Weapon('light hammer', B, 301),
    new Weapon('handaxe', S, 306),
    new Weapon('kukri', S, 308),
    new Weapon('lance', P, 310),
    new Weapon('longbow', P, 375, Ranged, Wood),
    new Weapon('composite longbow', P, 400, Ranged, Wood), // TODO: str rating
    new Weapon('arrows (20)', P, 121, Ranged),
    new Weapon('longsword', S, 315),
    new Weapon('heavy pick',  P, 308),
    new Weapon('light pick', P, 304),
    new Weapon('ranseur', P, 310),
    new Weapon('rapier', P, 320),
    new Weapon('sap', B, 301, Melee, None),
    new Weapon('scimitar', S, 315),
    new Weapon('scythe', P | S, 318),
    new Weapon('shortbow', P, 330, Ranged, Wood),
    new Weapon('composite shortbow', P, 375, Ranged, Wood),
    new Weapon('starknife', P, 324),
    new Weapon('short sword', P, 310),
    new Weapon('trident', P, 315),
    new Weapon('warhammer', B, 312),
    new Weapon('laser torch', F, 6000, Melee, None),
    new Weapon('stun baton', B | E, 5000, Melee, None),
    new Weapon('butterfly sword', S, 320),
    new Weapon('iron brush', B, 302),
    new Weapon('jutte', B, 308),
    new Weapon('kerambit', S, 302),
    new Weapon('lungchaun tamo', P | S, 305),
    new Weapon('shang gou', S, 306),
    new Weapon('tonfa', B, 301, Melee, Wood),
    new Weapon('wushu dart (5)', P, 301, Ranged, Metal),
    new Weapon('nine ring broadsword', S, 315),
    new Weapon('double chicken saber', S, 312),
    new Weapon('sibat', P | S, 302, Melee, Wood | Metal),
    new Weapon('hooked lance', P, 303, Melee, Wood | Metal),
    new Weapon('monk\'s spade', B | P | S, 320, Melee, Wood | Metal, true),
    new Weapon('naginata', S, 335, Melee, Wood | Metal),
    new Weapon('nodachi', P | S, 360),
    new Weapon('sansetsukon', B, 308, Melee, Wood),
    new Weapon('tri-point double-edged sword', P, 312),
    new Weapon('tiger fork', P, 305, Melee, Wood | Metal),
    new Weapon('tube arrow shooter', P, 303, Ranged),
    new Weapon('bamboo shaft arrow (10)', P, 301, Ranged, Metal),
    new Weapon('iron-tipped distance arrow (20)', P, 301, Ranged, Metal)
];

$weapons_exotic = [
    new Weapon('orc double axe', S, 660, Melee, Metal, true),
    new Weapon('bolas', B, 305, Ranged, None),
    new Weapon('spiked chain', P, 325),
    new Weapon('hand crossbow', P, 400, Ranged, None),
    new Weapon('hand crossbow bolts (10)', P, 61, Ranged),
    new Weapon('repeating heavy crossbow', P, 700, Ranged, None),
    new Weapon('repeating light crossbow', P, 550, Ranged, None),
    new Weapon('repeating crossbow bolts (5)', P, 31, Ranged),
    new Weapon('elven curve blade', S, 380),
    new Weapon('dire flail', B, 690, Melee, Metal, true),
    new Weapon('gnome hooked hammer', B | P, 620, Melee, Metal, true),
    new Weapon('kama', S, 302),
    new Weapon('net', None, 320, Ranged, None),
    new Weapon('nunchaku', B, 302, Melee, Wood),
    new Weapon('sai', B, 301),
    new Weapon('shuriken (5)', P, 31, Ranged),
    new Weapon('siangham', P, 303),
    new Weapon('halfling sling staff', B, 320, Ranged, Wood),
    new Weapon('bastard sword', S, 335),
    new Weapon('two-bladed sword', S, 700, Melee, Metal, true),
    new Weapon('dwarven urgrosh', P | S, 650, Melee, Metal, true),
    new Weapon('dwarven waraxe', S, 330),
    new Weapon('whip', S, 301, Melee, None),
    new Weapon('monowhip', S, 70000, Melee, None),
    new Weapon('chainsaw', S, 2700),
    new Weapon('bich\'hwa', P | S, 305),
    new Weapon('dan bong', B, 301, Melee, Wood),
    new Weapon('emei piercer', P, 303),
    new Weapon('fighting fan', P | S, 305),
    new Weapon('pata', P, 314),
    new Weapon('tekko-kagi', P, 302),
    new Weapon('wakizashi', P | S, 335),
    new Weapon('katana', S, 350),
    new Weapon('nine-section whip', B, 308),
    new Weapon('temple sword', S, 330),
    new Weapon('tetsubo', B, 320, Melee, Wood | Metal)
];

$weapons_firearms = [
    new Weapon('buckler gun', B | P, 488, Ranged, None),
    new Weapon('pepperbox', B | P, 1050, Ranged, None),
    new Weapon('pistol', B | P, 550, Ranged, None),
    new Weapon('coat pistol', B | P, 488, Ranged, None),
    new Weapon('dagger pistol', B | P, 485, Ranged, None),
    new Weapon('double-barreled pistol', B | P, 738, Ranged, None),
    new Weapon('dragon pistol', B | P, 550, Ranged, None),
    new Weapon('sword-cane pistol', B | P, 494, Ranged, None),
    new Weapon('blunderbuss', B | P, 800, Ranged, None),
    new Weapon('culverin', B | P, 1300, Ranged, None),
    new Weapon('double hackbutt', B | P, 1300, Ranged, None),
    new Weapon('musket', B | P, 675, Ranged, None),
    new Weapon('axe musket', B | P, 700, Ranged, None),
    new Weapon('double-barreled musket', B | P, 925, Ranged, None),
    new Weapon('warhammer musket', B | P, 700, Ranged, None),
    new Weapon('revolver', B | P, 1300, Ranged, None),
    new Weapon('rifle', B | P, 1550, Ranged, None),
    new Weapon('pepperbox rifle', B | P, 2050, Ranged, None),
    new Weapon('shotgun', B | P, 1550, Ranged, None),
    new Weapon('double-barreled shotgun', B | P, 2050, Ranged, None),
    new Weapon('dragon\'s breath alchemical cartridge (10)', B | P, 100, Ranged),
    new Weapon('entangling shot alchemical cartridge (10)', B | P, 100, Ranged),
    new Weapon('flare alchemical cartridge (10)', B | P, 25, Ranged),
    new Weapon('salt shot alchemical cartridge (10)', B | P, 30, Ranged),
    new Weapon('black powder dose (30)', B | P, 75, Ranged, None),
    new Weapon('firearm bullet (30)', B | P, 225, Ranged),
    new Weapon('metal cartridge (30)', B | P, 113, Ranged),
    new Weapon('pellet handful (30)', B | P, 225, Ranged, None),
    new Weapon('arc pistol', E, 10000, Ranged, None),
    new Weapon('dart gun', P, 3000, Ranged, None),
    new Weapon('EMP pistol', E, 12000, Ranged, None),
    new Weapon('gravity pistol', None, 95000, Ranged, None),
    new Weapon('laser pistol', F, 10000, Ranged, None),
    new Weapon('sonic pistol', None, 13000, Ranged, None),
    new Weapon('stun gun', None, 3000, Ranged, None),
    new Weapon('zero pistol', None, 15000, Ranged, None),
    new Weapon('arc rifle', E, 20000, Ranged, None),
    new Weapon('EMP rifle', E, 24000, Ranged, None),
    new Weapon('gravity rifle',  None, 165000, Ranged, None),
    new Weapon('laser rifle', F, 20000, Ranged, None),
    new Weapon('sonic rifle', None, 26000, Ranged, None),
    new Weapon('zero rifle', None, 20000, Ranged, None),
    new Weapon('plasmathrower', E | F, 30000, Ranged, None),
    new Weapon('rail gun', B | P, 30000, Ranged, None),
    new Weapon('rocket launcher', B | F, 10800, Ranged, None)
];

$weaponenh_melee = [
    new WeaponEnh(0, 'impervious', 3000),
    new WeaponEnh(0, 'glamered', 4000),
    new WeaponEnh(1, 'allying'),
    new WeaponEnh(1, 'bane', 0, 'bane_table'),
    new WeaponEnh(1, 'benevolent'),
    new WeaponEnh(1, 'called'),
    new WeaponEnh(1, 'conductive'),
    new WeaponEnh(1, 'corrosive'),
    new WeaponEnh(1, 'countering'),
    new WeaponEnh(1, 'courageous'),
    new WeaponEnh(1, 'cruel'),
    new WeaponEnh(1, 'cunning'),
    new WeaponEnh(1, 'deadly'),
    new WeaponEnh(1, 'defending'),
    new WeaponEnh(1, 'dispelling'),
    new WeaponEnh(1, 'flaming'),
    new WeaponEnh(1, 'frost'),
    new WeaponEnh(1, 'furious'),
    new WeaponEnh(1, 'ghost touch'),
    new WeaponEnh(1, 'grayflame'),
    new WeaponEnh(1, 'grounding'),
    new WeaponEnh(1, 'guardian'),
    new WeaponEnh(1, 'heartseeker'),
    new WeaponEnh(1, 'huntsman'),
    new WeaponEnh(1, 'jurist'),
    new WeaponEnh(1, 'keen', 0, '', 'keen_valid'),
    new WeaponEnh(1, 'ki focus'),
    new WeaponEnh(1, 'limning'),
    new WeaponEnh(1, 'menacing'),
    new WeaponEnh(1, 'merciful'),
    new WeaponEnh(1, 'mighty cleaving'),
    new WeaponEnh(1, 'mimetic'),
    new WeaponEnh(1, 'neutralizing'),
    new WeaponEnh(1, 'ominous'),
    new WeaponEnh(1, 'planar'),
    new WeaponEnh(1, 'quenching'),
    new WeaponEnh(1, 'seaborne'),
    new WeaponEnh(1, 'shock'),
    new WeaponEnh(1, 'spell storing'),
    new WeaponEnh(1, 'thawing'),
    new WeaponEnh(1, 'throwing'),
    new WeaponEnh(1, 'thundering'),
    new WeaponEnh(1, 'valiant'),
    new WeaponEnh(1, 'vicious'),
    new WeaponEnh(2, 'advancing'),
    new WeaponEnh(2, 'anarchic'),
    new WeaponEnh(2, 'anchoring'),
    new WeaponEnh(2, 'axiomatic'),
    new WeaponEnh(2, 'corrosive'),
    new WeaponEnh(2, 'defiant'),
    new WeaponEnh(2, 'dispelling'),
    new WeaponEnh(2, 'disruption', 0, '', 'disruption_valid'),
    new WeaponEnh(2, 'flaming burst'),
    new WeaponEnh(2, 'furyborn'),
    new WeaponEnh(2, 'glorious'),
    new WeaponEnh(2, 'holy'),
    new WeaponEnh(2, 'icy burst'),
    new WeaponEnh(2, 'igniting'),
    new WeaponEnh(2, 'impact'), // TODO: no light weapons
    new WeaponEnh(2, 'invigorating'),
    new WeaponEnh(2, 'ki intensifying'),
    new WeaponEnh(2, 'lifesurge'),
    new WeaponEnh(2, 'negating'),
    new WeaponEnh(2, 'phase locking'),
    new WeaponEnh(2, 'shocking burst'),
    new WeaponEnh(2, 'stalking'),
    new WeaponEnh(2, 'unholy'),
    new WeaponEnh(2, 'wounding'),
    new WeaponEnh(3, 'nullifying'),
    new WeaponEnh(3, 'repositioning'),
    new WeaponEnh(3, 'speed'),
    new WeaponEnh(3, 'spell stealing'),
    new WeaponEnh(4, 'brilliant energy'),
    new WeaponEnh(4, 'dancing'),
    new WeaponEnh(5, 'vorpal', 0, '', 'vorpal_valid'),
    new WeaponEnh(0, 'transformative', 10000),
    new WeaponEnh(0, 'dueling', 14000)
];

$weaponenh_ranged_base = [
    new WeaponEnh(0, 'impervious', 3000),
    new WeaponEnh(0, 'glamered', 4000),
    new WeaponEnh(1, 'allying'),
    new WeaponEnh(1, 'bane', 0, 'bane_table'),
    new WeaponEnh(1, 'called'),
    new WeaponEnh(1, 'conductive'),
    new WeaponEnh(1, 'corrosive'),
    new WeaponEnh(1, 'cruel'),
    new WeaponEnh(1, 'cunning'),
    new WeaponEnh(1, 'distance'),
    new WeaponEnh(1, 'flaming'),
    new WeaponEnh(1, 'frost'),
    new WeaponEnh(1, 'huntsman'),
    new WeaponEnh(1, 'jurist'),
    new WeaponEnh(1, 'limning'),
    new WeaponEnh(1, 'merciful'),
    new WeaponEnh(1, 'planar'),
    new WeaponEnh(1, 'seeking'),
    new WeaponEnh(1, 'shock'),
    new WeaponEnh(1, 'thundering'),
    new WeaponEnh(2, 'anarchic'),
    new WeaponEnh(2, 'axiomatic'),
    new WeaponEnh(2, 'corrosive burst'),
    new WeaponEnh(2, 'lesser designating'),
    new WeaponEnh(2, 'endless ammunition', 0, '', 'endless_valid'),
    new WeaponEnh(2, 'flaming burst'),
    new WeaponEnh(2, 'holy'),
    new WeaponEnh(2, 'icy burst'),
    new WeaponEnh(2, 'igniting'),
    new WeaponEnh(2, 'phase locking'),
    new WeaponEnh(2, 'shocking burst'),
    new WeaponEnh(2, 'stalking'),
    new WeaponEnh(2, 'unholy'),
    new WeaponEnh(3, 'greater lucky'),
    new WeaponEnh(3, 'speed'),
    new WeaponEnh(4, 'brilliant energy'),
    new WeaponEnh(4, 'greater designating'),
    new WeaponEnh(4, 'nimble shot'),
    new WeaponEnh(4, 'second chance')
];

$weaponenh_ranged = array_merge($weaponenh_ranged_base, [
    new WeaponEnh(0, 'adaptive', 1000, '', 'adaptive_valid'),
    new WeaponEnh(1, 'conserving'),
    new WeaponEnh(1, 'returning', 0, '', 'thrown_only_valid'),
    new WeaponEnh(2, 'anchoring', 0, '', 'thrown_only_valid')
]);

$weaponenh_firearms = array_merge($weaponenh_ranged_base, [
    new WeaponEnh(1, 'lucky'),
    new WeaponEnh(1, 'reliable'),
    new WeaponEnh(3, 'greater reliable')
]);

$weaponenh_ammo = [
    new WeaponEnh(0, 'dry load', 1500, '', 'dryload_valid'),
    new WeaponEnh(1, 'bane', 0, 'bane_table'),
    new WeaponEnh(1, 'conductive'),
    new WeaponEnh(1, 'corrosive'),
    new WeaponEnh(1, 'cruel'),
    new WeaponEnh(1, 'cunning'),
    new WeaponEnh(1, 'flaming'),
    new WeaponEnh(1, 'frost'),
    new WeaponEnh(1, 'ghost touch'),
    new WeaponEnh(1, 'limning'),
    new WeaponEnh(1, 'merciful'),
    new WeaponEnh(1, 'planar'),
    new WeaponEnh(1, 'seeking'),
    new WeaponEnh(1, 'shock'),
    new WeaponEnh(1, 'thundering'),
    new WeaponEnh(2, 'anarchic'),
    new WeaponEnh(2, 'axiomatic'),
    new WeaponEnh(2, 'corrosive burst'),
    new WeaponEnh(2, 'lesser designating'),
    new WeaponEnh(2, 'flaming burst'),
    new WeaponEnh(2, 'holy'),
    new WeaponEnh(2, 'icy burst'),
    new WeaponEnh(2, 'igniting'),
    new WeaponEnh(2, 'phase locking'),
    new WeaponEnh(2, 'shocking burst'),
    new WeaponEnh(2, 'unholy'),
    new WeaponEnh(4, 'brilliant energy'),
    new WeaponEnh(4, 'greater designating')
];
?>
