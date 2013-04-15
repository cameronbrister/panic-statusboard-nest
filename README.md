Nest Panel for Panic's Status Board for iOS
---

Generates a panel for <a href="http://panic.com/statusboard/">Panic's Status Board</a> for iOS that displays current stats for a Nest thermostat using PHP.

Release Notes
---
This is very much a first-run release. I plan to nix the meta refresh in favor of AJAX. This will stop the fan icon from disappearing momentarily on refresh if the fan on the Nest is actually running.

Acknowledgements
---
* Uses Guillaume Boudreau's Nest API written in PHP, with a few slight modifications - https://github.com/gboudreau/nest-api
* Icons from Nest's official dashboard - https://home.nest.com/home
