# Campaign Loot Roller (Pathfinder d20)

This is a simple web-based loot roller for [Pathfinder](http://paizo.com/pathfinderRPG/). It's not generally useful as-is since I've customized it
for my particular campaign-specific rules. In particular, there are adjustments to support [innate item bonuses](http://paizo.com/pathfinderRPG/prd/unchained/magic/innateItemBonuses.html) and campaign-specific
pricing. But it should be easy to adapt, as I've tried to make it obvious where the code deviates from standard path. Also the roller
doesn't try too hard to recover from items that are out of bounds... instead it returns a nonsensical "glitch" item which only makes
sense in my campaign.

Most of the loot tables are based off of the [Game Mastery Guide](http://paizo.com/products/btpy8ffn?Pathfinder-Roleplaying-Game-GameMastery-Guide), though some are cobbled from other locations. The generated loot is a
bit more random since I didn't want to re-create the weighting in the guide's charts. Also the equivalent loot for character level
formulae is still a work in progress and may not match with what's appropriate for any given group's level, and as it stands probably
skews toward giving away too much loot rather than too little.

## Usage

It's pretty straight-forward. Once you have the web site setup, you just go to the index page and can twiddle a few settings and click "OK".
The way I use it is to roll the loot until I get something I'm satisfied with, then I screenshot the rolled items and share with my
players. Weapons and armor have their enchantments shown, but most other items you'll need a copy of the Pathfinder rules to look up the
specific statistics.

## Dependencies

 * [PHP 5.2+](http://php.net/) - I use [XAMPP](https://www.apachefriends.org/index.html) to develop and run.
 * Images - The images I'm using are from a non-free pack that I purchased, so they're not in the repository. You'll want to supply your own images.

## License

Code is licensed under the [CC0 1.0 universal license](LICENSE.md).

Based on Pathfinder RPG rules published under [OGL 1.0a](LICENSE.md) from Paizo, LLC.