#!/usr/bin/python3

import json
import urllib.request
from influxdb import InfluxDBClient

geturl = "https://example.com/torque_get.php?id=348394827389472309847298374"

influxHost = "localhost"
influxPort = 8086
influxDB = "ev"

def influx(lpd):
        print(lpd)
        cli = InfluxDBClient(host=influxHost, port=influxPort, database=influxDB)
        cli.write_points(lpd, protocol='line', time_precision='ms')

resp = urllib.request.urlopen(geturl)
lines = [l.decode() for l in resp.read().split(b"\n") if l != b'']

lines += [f'ingest cnt={len(lines)}']
influx(lines)
