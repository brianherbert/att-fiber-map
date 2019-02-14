# att-fiber-map

Address data found on http://results.openaddresses.io/?runs=all#runs

http://bl.ocks.org/sumbera/10463358 for adding a ton of markers to a leaflet map using D3

## Getting Started

* Create a database and add the table in the `schema.sql` file.
* Copy the db-example.php to db.php and add your db credentials.
* Add addresses to your addresses table. I simply used a CSV from openaddresses.io to populate the db (lon, lat, number, street, city, district, region, postcode, hash). This isn't automated, you'll need to do this on your own.
* Run `worker.php` from the command line. This will continually look for fiber on AT&T from addresses in your databse. These will be selected at random continuously until all of the addresses have been covered, then it will continusly update the rows from the oldest.
* Run `make-csv.php` to generate the hasGig.csv file with all of the lat,lon coordinates for addresses that have fiber available to them.
* Load up `index.html` in your browser to see the locations visualized. (You may need to modify index.html with new starting coordinates)

## Todo

* In the future, hasGig.csv may not be included with the repo but leaving it in for now as an example.
* Set starting bounding box based on CSV data instead of setting it statically in index.html.
* Update the very old versions of Leaflet and D3