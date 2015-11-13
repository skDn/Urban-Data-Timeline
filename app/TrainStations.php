<!-- 
status when this property has the value "OK", it means that the request is successful and the results are valid. Otherwise, there is an error.
trainStations is an array containing the train stations found. Each Object in the array represent a train station.

	The train station object in the trainStations array contains the following properties (Please consult the NaPTAN documentation for more details about some of these properties ):
	atcoCode is the ATCO code of the station used by journey planners, e.g. "9100CHRNGXG"
	crsCode is the Computer reservation system code of the station, e.g. "CHC"
	stationName e.g. Charing Cross (Glasgow) Rail Station
	stopLat the latitude of the station
	stopLon the longitude of the station
	tiplocCode the timing point location code. This is the key used in the delay services end point. 

{"request": {"lat": 55.8580 , "lon":-4.2590, "radius": 1.0}}
-->