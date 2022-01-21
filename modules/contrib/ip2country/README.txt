About
=====
This module uses a visitor's IP address to identify the geographical location
(country) of the user.  The module makes this determination and stores the
result as an ISO 3166-1 2-character country code in the Drupal $user object,
but otherwise has no effect on the operation of your site.  The intent is
simply to provide the information for use by other modules.  Anonymous users
are not identified by country.  An API is also provided so that you can lookup
IP-Country information in your own code.



Installation
============
Check requirements:  Drupal 8.x, nothing more.

Copy ip2country.tar.gz into your sites/all/modules directory and unzip/untar it.

In your web browser, navigate to admin/modules and enable the following
module: IP-based determination of Country

NOTE!  When ip2country is installed, it downloads a large amount of
data off the Internet to build a table in your Drupal database.  This
process can take up to 30 seconds, so please be patient and WAIT until
the page loads!  You can verify a correct install by looking into your
Drupal database for the ip2country table and verifying that it is full
of data.

This module defines an "administer ip2country" permission, which must be
explicitly enabled for the administration user at admin/people/permissions.

You must now enter values in the administration menus.  Defaults are chosen
reasonably, but you should examine them and set them as you wish.

Go to admin/config/people/ip2country to review and change settings for the
IP-based determination of Country module.  You can read about the Debug
preferences in the "Troubleshooting" section below.

Finally, cron needs to be running for automatic database updates.  If you
haven't set up cron for your Drupal site, refer to
https://www.drupal.org/docs/8/cron-automated-tasks/cron-automated-tasks-overview
for instructions.

Everything should now work.  If it doesn't, read the rest of this document
(which you really should have done first, anyway!).  If you still have
problems see the "Troubleshooting" section below.



Features
========
This module uses the IP Address that a user is connected from to deduce the
Country where the user is located.  This method is not foolproof, because
a user may connect through an anonymizing proxy, or may be in an unusual
situation, such as using an ISP from a neighboring country, or using an
IP block leased from a company in another country.  Additionally, users
accessing a server on a local network may be using an IP that is not assigned
to any country (e.g. 192.168.1.x or 127.0.0.1).

Country determination occurs upon user login.  If a country can be determined
from the IP address, the ISO 3166 2-character country code is stored in the
Drupal $user object as $user->country_iso_code_2.  If no country can be
determined, this member variable is left unset.

Rules support allows you to detect the user's country and take action
depending on the value.  For instance, you could have customized landing pages
for users from different countries, or show/hide content based on the user's
country (e.g. a product not available for sale in a certain country).  An
example Reaction Rule is included with this module - it will be automatically
installed but set to "disabled" so it will not run until you manually "enable"
it from the Rules UI.  You may edit this example for your own needs, or just use
it as reference.  The Rule is named "Login redirect - ES" and it demonstrates
how to redirect a user at login in time, based on the country of that user's
IP address.

Alternatively, a function is provided so that you may look up the country
from within your own code, for your own use.  The way to use this is:

  $ip = \Drupal::request()->getClientIp();
  $country_code = \Drupal::service('ip2country.lookup')->getCountry($ip);

Drupal core provides a function which can transform this $country_code into
a country name.  Use it like this:

  $country_list = \Drupal::service('country_manager')->getList();
  $country_name = $country_list[$country_code];


The database used by this module is maintained by ARIN, the American Registry
for Internet Numbers (http://www.arin.net/about_us/index.html), which is one of
the five official Regional Internet Registries (RIR) responsible for assigning
IP addresses.  The claim is the database is 98% accurate, with most of the
problems coming from users in less-developed countries.  Regardless, there's
no more-authoritative source of this information.  Although the default RIR
used is ARIN, an admin menu allows you to choose any of the five.

If you have cron set up for your Drupal site, this IP to Country database will
be automatically updated at a frequency determined by the admin menu at
admin/config/people/ip2country.  A checkbox is provided to turn on/off
logging of database updates.  The default update frequency is 1 week, but it
can be adjusted from 1 day up to 4 weeks.  Because this module downloads a lot
of data during the update and because the database is very stable, shorter
database update times are not needed.

Database updates may also be performed manually by pressing the button at
admin/config/people/ip2country.  Note this can take up to 30 seconds to
complete - do not interrupt the update process or the update will fail and you
will have to do it again.  (A failed update does *not* corrupt the database.)


Drush support
=============
Support for both Drush 8 and Drush 9+ has been added. There are three drush
commands provided by this module (use a '-' instead of the ':' in the command
name if you are using Drush 8):

  drush ip2country:update --registry=<registry>
      Updates the ip2country database from the specified registry, or from
      the default registry if not specified.

  drush ip2country:lookup <ip>
      Looks up the given IP address in the ip2country database displays the
      country associated with that IP address.

  drush ip2country:status
      Prints the time and data source (RIR) of the last database update.

Drush may also be used to configure any of the settings for this program.  For
example, to see all the settings, use:

  drush cget ip2country.settings

And to change the settings, use the corresponding drush cset.  For example, to
disable automatic database updates, use:

  drush cset ip2country.setttings update_interval 0

Or to turn on debug country/IP spoofing, use:

  drush cset ip2country.setttings debug true

More help may be found using drush help --filter=ip2country


Requirements
============
This module is tested to work with Drupal 8.x.  There is a separate version
specifically for Drupal 7.x (and for Drupal 6.x and for Drupal 5.x too, if you
still need that).  Future version of this module will be backwards compatible
with this release.



Troubleshooting
===============
Because it's not practical to log in from another country in order to test
these features, a debugging setting is provided to allow the administrator
to specify a Country or IP Address to simulate.  When debugging is enabled,
it only affects the country stored in the administrator's $user object.
To use this debugging setting, check the box "Admin Debug" at
admin/config/people/ip2country.  You must also specify either a Country to
simulate or an IP to simulate.  A notification will be printed across the top
of the page when you submit the form, letting you know that the debug feature
has successfully been turned on (or off).  The simulated Country or IP will be
used for the administrator until this feature is turned off in the admin menu.

If your dblog indicates that the database update is failing due to timeouts,
you may have to increase Drupal's allowed cron run time.  This requires editing
core/lib/Drupal/Core/Cron.php and changing the time in the function run()
from 240 a larger number.  Note that this problem is extremely unlikely if
you have a version of this module >=8.x-1.9.

When all else fails, read the comments in the code - there are some debugging
print statements left in that can be uncommented to see what is going on, and
most functions are described in the comments.
