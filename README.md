# torque-to-influx
Accepts PIDs from Torque logging, remaps, and sends to InfluxDB by putting into a file that is retrieved by a second component.

Very rough, but does what I need.  Putting it out here in case it sparks someone else's ideas.

Two components allow the ingest part to be on a separate public-facing URL while the InfluxDB server is internal and not attached at all.

`scrape-torque` folder component is a Python script that should be run as a cron job with preferred granularity that retrieves the accumulated data from the PHP ingest component and sends it via the InfluxDB client package.

### Configuring
Three values to set in `torque_config.php` plus whatever PID mapping and range checking applies.

Also fetch URL and InfluxDB parameters need to be edited in the `scrape-torque.py` file.
