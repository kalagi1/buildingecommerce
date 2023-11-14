
(function (factory) {
	if (typeof define === 'function' && define.amd) {
		//AMD
		define(['jquery', 'leaflet'], factory);
	} else if (typeof module !== 'undefined') {
		// Node/CommonJS
		module.exports = factory(require('jquery', 'leaflet'));
	} else {
		// Browser globals
		if (typeof window.jQuery === 'undefined')
			throw 'jQuery must be loaded first';
		if (typeof window.L === 'undefined')
			throw 'Leaflet must be loaded first';
		factory(window.jQuery, window.L);
	}
})(function (jQuery, L) {

	var $ = jQuery;

	$.fn.leafletLocationPicker = function (opts, onChangeLocation) {

		var http = window.location.protocol;

		var baseClassName = 'leaflet-locpicker',
			baseLayers = {
				'OSM': http + '//{s}.tile.openstreetmap.org/{z}/{x}/{y}.png',
				'SAT': http + '//otile1.mqcdn.com/tiles/1.0.0/sat/{z}/{x}/{y}.png'
				//TODO add more free base layers
			};

		var optsMap = {
			zoom: 5,
			center: L.latLng([40, 0]),
			zoomControl: false,
			attributionControl: true
		};

		if ($.isPlainObject(opts) && $.isPlainObject(opts.map))
			optsMap = $.extend(optsMap, opts.map);

		var defaults = {
			alwaysOpen: false,
			className: baseClassName,
			location: optsMap.center,
			locationFormat: '{lat}{sep}{lng}',
			locationMarker: true,
			locationDigits: 6,
			locationSep: ',',
			position: 'topright',
			layer: 'OSM',
			height: 140,
			width: 200,
			event: 'click',
			cursorSize: '30px',
			map: optsMap,
			onChangeLocation: $.noop,
			mapContainer: ""
		};

		if ($.isPlainObject(opts))
			opts = $.extend(defaults, opts);

		else if ($.isFunction(opts))
			opts = $.extend(defaults, {
				onChangeLocation: opts
			});
		else
			opts = defaults;

		if ($.isFunction(onChangeLocation))
			opts = $.extend(defaults, {
				onChangeLocation: onChangeLocation
			});

		function roundLocation(loc) {
			return loc ? L.latLng(
				parseFloat(loc.lat).toFixed(opts.locationDigits),
				parseFloat(loc.lng).toFixed(opts.locationDigits)
			) : loc;
		}

		function parseLocation(loc) {
			var retLoc = loc;

			switch ($.type(loc)) {
				case 'string':
					var ll = loc.split(opts.locationSep);
					if (ll[0] && ll[1])
						retLoc = L.latLng(ll);
					else
						retLoc = null;
					break;
				case 'array':
					retLoc = L.latLng(loc);
					break;
				case 'object':
					var lat, lng;
					if (loc.hasOwnProperty('lat'))
						lat = loc.lat;
					else if (loc.hasOwnProperty('latitude'))
						lat = loc.latitude;

					if (loc.hasOwnProperty('lng'))
						lng = loc.lng;
					else if (loc.hasOwnProperty('lon'))
						lng = loc.lon;
					else if (loc.hasOwnProperty('longitude'))
						lng = loc.longitude;

					retLoc = L.latLng(parseFloat(lat), parseFloat(lng));
					break;
				default:
					retLoc = loc;
			}
			return roundLocation(retLoc);
		}

		function buildMap(self) {

			self.divMap = document.createElement('div');
			self.$map = $(document.createElement('div'))
				.addClass(opts.className + '-map')
				.height(opts.height)
				.width(opts.width)
				.append(self.divMap);
			//adds either as global div or specified container
			//if added to specified container add some style class
			if (opts.mapContainer && $(opts.mapContainer))
				self.$map.appendTo(opts.mapContainer)
					.addClass('map-select');
			else
				self.$map.appendTo('body');

			if (self.location)
				opts.map.center = self.location;

			if (typeof opts.layer === 'string' && baseLayers[opts.layer])
				opts.map.layers = L.tileLayer(baseLayers[opts.layer]);

			else if (opts.layer instanceof L.TileLayer ||
				opts.layer instanceof L.LayerGroup)
				opts.map.layers = opts.layer;

			else
				opts.map.layers = L.tileLayer(baseLayers.OSM);

			//leaflet map
			self.map = L.map(self.divMap, opts.map)
				.addControl(L.control.zoom({ position: 'bottomright' }))
				.on(opts.event, function (e) {
					self.setLocation(e.latlng);
				});

			var data = [
				[
				  35.0719158,
				  38.6393772
				],
				[
				  35.0734283,
				  38.6432461
				],
				[
				  35.0739864,
				  38.6441725
				],
				[
				  35.0742642,
				  38.6451067
				],
				[
				  35.0734703,
				  38.6452603
				],
				[
				  35.0738008,
				  38.6462056
				],
				[
				  35.0745156,
				  38.6461114
				],
				[
				  35.0737922,
				  38.6469678
				],
				[
				  35.0758406,
				  38.6467644
				],
				[
				  35.0777361,
				  38.6464667
				],
				[
				  35.0799892,
				  38.6460914
				],
				[
				  35.0853978,
				  38.6452217
				],
				[
				  35.0893225,
				  38.6446119
				],
				[
				  35.0881736,
				  38.6457217
				],
				[
				  35.0879058,
				  38.6459803
				],
				[
				  35.0876464,
				  38.6462203
				],
				[
				  35.0874556,
				  38.6464325
				],
				[
				  35.0871914,
				  38.6467131
				],
				[
				  35.0869192,
				  38.6470158
				],
				[
				  35.0867767,
				  38.6471906
				],
				[
				  35.0864792,
				  38.6475842
				],
				[
				  35.0862231,
				  38.6478869
				],
				[
				  35.08606,
				  38.6480961
				],
				[
				  35.0858206,
				  38.6483614
				],
				[
				  35.0856367,
				  38.6483481
				],
				[
				  35.0854247,
				  38.6483247
				],
				[
				  35.0851672,
				  38.6482756
				],
				[
				  35.0848381,
				  38.6482106
				],
				[
				  35.0846653,
				  38.6484775
				],
				[
				  35.0846086,
				  38.648565
				],
				[
				  35.0844858,
				  38.6487431
				],
				[
				  35.0843731,
				  38.6489161
				],
				[
				  35.0843253,
				  38.6489942
				],
				[
				  35.0841833,
				  38.6491608
				],
				[
				  35.0840617,
				  38.6493306
				],
				[
				  35.08392,
				  38.6493106
				],
				[
				  35.0837064,
				  38.649245
				],
				[
				  35.0835353,
				  38.6491883
				],
				[
				  35.0833789,
				  38.6491247
				],
				[
				  35.0832353,
				  38.6490578
				],
				[
				  35.0830422,
				  38.6489944
				],
				[
				  35.0828375,
				  38.6489128
				],
				[
				  35.08252,
				  38.6487994
				],
				[
				  35.0824158,
				  38.6489328
				],
				[
				  35.0823622,
				  38.6489936
				],
				[
				  35.0823158,
				  38.6490533
				],
				[
				  35.0822653,
				  38.6491747
				],
				[
				  35.0822497,
				  38.6492436
				],
				[
				  35.0822053,
				  38.6493811
				],
				[
				  35.0821278,
				  38.6495714
				],
				[
				  35.08207,
				  38.6496928
				],
				[
				  35.0820286,
				  38.6498178
				],
				[
				  35.0819886,
				  38.6499989
				],
				[
				  35.0821553,
				  38.6500475
				],
				[
				  35.0824114,
				  38.6501381
				],
				[
				  35.0825986,
				  38.6502003
				],
				[
				  35.0827683,
				  38.6502694
				],
				[
				  35.0829994,
				  38.6503681
				],
				[
				  35.08326,
				  38.6504817
				],
				[
				  35.0833567,
				  38.6505283
				],
				[
				  35.0832397,
				  38.6507325
				],
				[
				  35.0830983,
				  38.6510078
				],
				[
				  35.0830308,
				  38.6512058
				],
				[
				  35.0829767,
				  38.6513836
				],
				[
				  35.0832675,
				  38.6514764
				],
				[
				  35.0835761,
				  38.6515758
				],
				[
				  35.0837881,
				  38.6516347
				],
				[
				  35.0840219,
				  38.6516794
				],
				[
				  35.0842981,
				  38.6517253
				],
				[
				  35.0845436,
				  38.6517658
				],
				[
				  35.0847789,
				  38.6518094
				],
				[
				  35.0850228,
				  38.6518497
				],
				[
				  35.0852975,
				  38.6518853
				],
				[
				  35.0854233,
				  38.6519192
				],
				[
				  35.0853097,
				  38.6521886
				],
				[
				  35.085225,
				  38.6524236
				],
				[
				  35.0851647,
				  38.6525919
				],
				[
				  35.0851306,
				  38.652725
				],
				[
				  35.0850872,
				  38.6528339
				],
				[
				  35.0850381,
				  38.6528797
				],
				[
				  35.0850164,
				  38.6529244
				],
				[
				  35.084995,
				  38.6530069
				],
				[
				  35.0849347,
				  38.6531825
				],
				[
				  35.0848603,
				  38.6534264
				],
				[
				  35.0848061,
				  38.6536122
				],
				[
				  35.0847686,
				  38.6537244
				],
				[
				  35.0847128,
				  38.6538986
				],
				[
				  35.0847003,
				  38.6540119
				],
				[
				  35.0846733,
				  38.6541311
				],
				[
				  35.0846364,
				  38.6542675
				],
				[
				  35.0846008,
				  38.6544175
				],
				[
				  35.0845769,
				  38.6546122
				],
				[
				  35.084725,
				  38.6546953
				],
				[
				  35.0848481,
				  38.6547611
				],
				[
				  35.0848981,
				  38.6548056
				],
				[
				  35.0849967,
				  38.6549369
				],
				[
				  35.0850628,
				  38.655035
				],
				[
				  35.0850792,
				  38.6551003
				],
				[
				  35.0850753,
				  38.6551667
				],
				[
				  35.0850333,
				  38.6552331
				],
				[
				  35.0849814,
				  38.6553283
				],
				[
				  35.0848744,
				  38.6554811
				],
				[
				  35.0847469,
				  38.6556519
				],
				[
				  35.0846183,
				  38.6558472
				],
				[
				  35.0846186,
				  38.6558986
				],
				[
				  35.0846219,
				  38.65598
				],
				[
				  35.0846425,
				  38.656005
				],
				[
				  35.0847042,
				  38.6560403
				],
				[
				  35.0848019,
				  38.6560753
				],
				[
				  35.0849847,
				  38.6561272
				],
				[
				  35.0851692,
				  38.6561769
				],
				[
				  35.0853475,
				  38.6562289
				],
				[
				  35.0855333,
				  38.6562925
				],
				[
				  35.0856767,
				  38.6563353
				],
				[
				  35.0856969,
				  38.6563261
				],
				[
				  35.0857217,
				  38.6563067
				],
				[
				  35.0858167,
				  38.6563164
				],
				[
				  35.0859278,
				  38.6563517
				],
				[
				  35.0860608,
				  38.6563922
				],
				[
				  35.0862086,
				  38.6564364
				],
				[
				  35.0863183,
				  38.6564783
				],
				[
				  35.0863447,
				  38.6565125
				],
				[
				  35.0863767,
				  38.6564917
				],
				[
				  35.0864,
				  38.6564608
				],
				[
				  35.0864567,
				  38.6564433
				],
				[
				  35.0867256,
				  38.6564972
				],
				[
				  35.0869244,
				  38.6565483
				],
				[
				  35.0870108,
				  38.6565786
				],
				[
				  35.0871919,
				  38.6566436
				],
				[
				  35.0874547,
				  38.6567453
				],
				[
				  35.0877744,
				  38.6568492
				],
				[
				  35.0880403,
				  38.6569347
				],
				[
				  35.0882639,
				  38.6570053
				],
				[
				  35.0884464,
				  38.6570533
				],
				[
				  35.0885236,
				  38.6570244
				],
				[
				  35.0885819,
				  38.65702
				],
				[
				  35.0891325,
				  38.6572047
				],
				[
				  35.0890906,
				  38.6573283
				],
				[
				  35.0890511,
				  38.657445
				],
				[
				  35.0890147,
				  38.6575486
				],
				[
				  35.0889619,
				  38.6576639
				],
				[
				  35.088875,
				  38.6578428
				],
				[
				  35.0888283,
				  38.6579525
				],
				[
				  35.0887494,
				  38.6580697
				],
				[
				  35.0886442,
				  38.6581947
				],
				[
				  35.0885333,
				  38.6582889
				],
				[
				  35.0883636,
				  38.6584269
				],
				[
				  35.0885319,
				  38.6585061
				],
				[
				  35.0887103,
				  38.6585981
				],
				[
				  35.0888522,
				  38.6586736
				],
				[
				  35.0889728,
				  38.6587283
				],
				[
				  35.0891031,
				  38.6588072
				],
				[
				  35.0892069,
				  38.6588964
				],
				[
				  35.0892814,
				  38.6589717
				],
				[
				  35.0894556,
				  38.6591717
				],
				[
				  35.0895739,
				  38.6592781
				],
				[
				  35.0896514,
				  38.6593203
				],
				[
				  35.0898325,
				  38.6593992
				],
				[
				  35.0896089,
				  38.6600953
				],
				[
				  35.0889092,
				  38.6615781
				],
				[
				  35.0887225,
				  38.6616983
				],
				[
				  35.0885828,
				  38.6618358
				],
				[
				  35.0884194,
				  38.661955
				],
				[
				  35.0883656,
				  38.6620033
				],
				[
				  35.0882317,
				  38.6622642
				],
				[
				  35.0881289,
				  38.6623717
				],
				[
				  35.0880158,
				  38.6625183
				],
				[
				  35.087925,
				  38.6626503
				],
				[
				  35.0878444,
				  38.6627789
				],
				[
				  35.0877317,
				  38.6629292
				],
				[
				  35.0876097,
				  38.6630992
				],
				[
				  35.0874625,
				  38.6632858
				],
				[
				  35.0874278,
				  38.6633431
				],
				[
				  35.0872339,
				  38.6635264
				],
				[
				  35.0872019,
				  38.6636375
				],
				[
				  35.0872769,
				  38.6639397
				],
				[
				  35.0872389,
				  38.66399
				],
				[
				  35.0871078,
				  38.6640736
				],
				[
				  35.0870231,
				  38.6640989
				],
				[
				  35.0867981,
				  38.6647858
				],
				[
				  35.0869353,
				  38.6648464
				],
				[
				  35.0870056,
				  38.6648669
				],
				[
				  35.0870814,
				  38.6649458
				],
				[
				  35.0872817,
				  38.6650336
				],
				[
				  35.08753,
				  38.6651467
				],
				[
				  35.0877125,
				  38.6652519
				],
				[
				  35.0879053,
				  38.6653444
				],
				[
				  35.0880325,
				  38.6653831
				],
				[
				  35.0880675,
				  38.6653797
				],
				[
				  35.0881464,
				  38.6654003
				],
				[
				  35.0881961,
				  38.6654792
				],
				[
				  35.0882806,
				  38.6653589
				],
				[
				  35.0883856,
				  38.6653175
				],
				[
				  35.0885536,
				  38.665345
				],
				[
				  35.0887917,
				  38.6654053
				],
				[
				  35.0889189,
				  38.6655069
				],
				[
				  35.0889772,
				  38.6656031
				],
				[
				  35.0890022,
				  38.6656272
				],
				[
				  35.0891411,
				  38.6657392
				],
				[
				  35.0891631,
				  38.6657836
				],
				[
				  35.0890769,
				  38.6658822
				],
				[
				  35.0889561,
				  38.6659522
				],
				[
				  35.0888072,
				  38.6660119
				],
				[
				  35.0887444,
				  38.6660589
				],
				[
				  35.0885944,
				  38.6661711
				],
				[
				  35.0882575,
				  38.6664336
				],
				[
				  35.0879442,
				  38.6667075
				],
				[
				  35.0877386,
				  38.6669103
				],
				[
				  35.0875944,
				  38.6670753
				],
				[
				  35.0875944,
				  38.6671014
				],
				[
				  35.0879103,
				  38.6673392
				],
				[
				  35.0881089,
				  38.6674636
				],
				[
				  35.0883061,
				  38.6675758
				],
				[
				  35.0884261,
				  38.6676764
				],
				[
				  35.0884239,
				  38.6677242
				],
				[
				  35.0883964,
				  38.6677608
				],
				[
				  35.0883658,
				  38.6677758
				],
				[
				  35.0884597,
				  38.6678386
				],
				[
				  35.0885711,
				  38.6679239
				],
				[
				  35.0887119,
				  38.6680231
				],
				[
				  35.0888308,
				  38.6681164
				],
				[
				  35.0889731,
				  38.6682258
				],
				[
				  35.089105,
				  38.6683294
				],
				[
				  35.0891433,
				  38.6683658
				],
				[
				  35.0889078,
				  38.6685247
				],
				[
				  35.0887247,
				  38.6686594
				],
				[
				  35.08888,
				  38.6687697
				],
				[
				  35.0889972,
				  38.6688392
				],
				[
				  35.089135,
				  38.6689256
				],
				[
				  35.0892728,
				  38.6689939
				],
				[
				  35.0893753,
				  38.6690344
				],
				[
				  35.0895906,
				  38.6691378
				],
				[
				  35.0897736,
				  38.6692219
				],
				[
				  35.0899378,
				  38.6693506
				],
				[
				  35.0900844,
				  38.6694611
				],
				[
				  35.0902706,
				  38.6695783
				],
				[
				  35.0903747,
				  38.6696272
				],
				[
				  35.0905647,
				  38.6696836
				],
				[
				  35.0907244,
				  38.6697678
				],
				[
				  35.0908403,
				  38.6698439
				],
				[
				  35.0909547,
				  38.6699294
				],
				[
				  35.0910933,
				  38.6699986
				],
				[
				  35.0910664,
				  38.6703797
				],
				[
				  35.0911308,
				  38.6717914
				],
				[
				  35.0911156,
				  38.6718447
				],
				[
				  35.0911175,
				  38.671925
				],
				[
				  35.0911006,
				  38.6720189
				],
				[
				  35.0910942,
				  38.67217
				],
				[
				  35.0911094,
				  38.6722797
				],
				[
				  35.0910014,
				  38.6722917
				],
				[
				  35.0907419,
				  38.6723431
				],
				[
				  35.0904561,
				  38.6724003
				],
				[
				  35.0905778,
				  38.6724994
				],
				[
				  35.0907392,
				  38.6726028
				],
				[
				  35.0909442,
				  38.6727167
				],
				[
				  35.0911478,
				  38.6728097
				],
				[
				  35.0914011,
				  38.6729381
				],
				[
				  35.0916383,
				  38.6730481
				],
				[
				  35.0918389,
				  38.67314
				],
				[
				  35.0920483,
				  38.6732264
				],
				[
				  35.0921903,
				  38.6732728
				],
				[
				  35.0920872,
				  38.6733967
				],
				[
				  35.0920061,
				  38.6735092
				],
				[
				  35.0918978,
				  38.6736642
				],
				[
				  35.0917761,
				  38.6738294
				],
				[
				  35.0916114,
				  38.6739967
				],
				[
				  35.0912464,
				  38.6744397
				],
				[
				  35.0911503,
				  38.6743756
				],
				[
				  35.0910647,
				  38.6743333
				],
				[
				  35.0909058,
				  38.6744222
				],
				[
				  35.0907264,
				  38.6746489
				],
				[
				  35.0906447,
				  38.6747931
				],
				[
				  35.0904647,
				  38.6750678
				],
				[
				  35.0902992,
				  38.6753239
				],
				[
				  35.0901967,
				  38.6754636
				],
				[
				  35.0900692,
				  38.6756483
				],
				[
				  35.0899172,
				  38.6758622
				],
				[
				  35.0897964,
				  38.6760308
				],
				[
				  35.0896311,
				  38.6762253
				],
				[
				  35.0895497,
				  38.6763247
				],
				[
				  35.0894531,
				  38.6764517
				],
				[
				  35.0893447,
				  38.6765825
				],
				[
				  35.0892156,
				  38.6767019
				],
				[
				  35.0890658,
				  38.6768069
				],
				[
				  35.0889983,
				  38.6768592
				],
				[
				  35.0888706,
				  38.6769719
				],
				[
				  35.0887531,
				  38.6770822
				],
				[
				  35.0886472,
				  38.6771719
				],
				[
				  35.0874608,
				  38.6792511
				],
				[
				  35.0873761,
				  38.6793981
				],
				[
				  35.0873311,
				  38.6794914
				],
				[
				  35.0871944,
				  38.6796717
				],
				[
				  35.0870817,
				  38.6798619
				],
				[
				  35.0870369,
				  38.67997
				],
				[
				  35.0869794,
				  38.6800897
				],
				[
				  35.0869036,
				  38.6802372
				],
				[
				  35.0868311,
				  38.6804031
				],
				[
				  35.086745,
				  38.6805531
				],
				[
				  35.0866403,
				  38.6807181
				],
				[
				  35.0865939,
				  38.6808033
				],
				[
				  35.0865692,
				  38.6808858
				],
				[
				  35.0865106,
				  38.6810242
				],
				[
				  35.0864472,
				  38.6811358
				],
				[
				  35.0863706,
				  38.6813211
				],
				[
				  35.0863192,
				  38.6814489
				],
				[
				  35.0863017,
				  38.6815303
				],
				[
				  35.0862719,
				  38.6816497
				],
				[
				  35.0862417,
				  38.6817339
				],
				[
				  35.0861644,
				  38.6818847
				],
				[
				  35.0860783,
				  38.6820392
				],
				[
				  35.0859808,
				  38.6821961
				],
				[
				  35.0858947,
				  38.6823506
				],
				[
				  35.0858297,
				  38.6824611
				],
				[
				  35.0858,
				  38.6824972
				],
				[
				  35.0857439,
				  38.6825494
				],
				[
				  35.0855744,
				  38.6826944
				],
				[
				  35.0855453,
				  38.6827117
				],
				[
				  35.0855083,
				  38.6825494
				],
				[
				  35.08549,
				  38.6824261
				],
				[
				  35.0854664,
				  38.6823567
				],
				[
				  35.0854306,
				  38.6823111
				],
				[
				  35.0852069,
				  38.6823769
				],
				[
				  35.0849044,
				  38.6825147
				],
				[
				  35.084645,
				  38.6826061
				],
				[
				  35.0844903,
				  38.6826172
				],
				[
				  35.0842933,
				  38.6826233
				],
				[
				  35.0840697,
				  38.6826936
				],
				[
				  35.0839253,
				  38.6828453
				],
				[
				  35.0838303,
				  38.6829794
				],
				[
				  35.0836933,
				  38.6830761
				],
				[
				  35.0834961,
				  38.6831417
				],
				[
				  35.0833044,
				  38.6832025
				],
				[
				  35.0831131,
				  38.6832656
				],
				[
				  35.0829342,
				  38.6833078
				],
				[
				  35.0828586,
				  38.6833272
				],
				[
				  35.0828464,
				  38.6835128
				],
				[
				  35.0828225,
				  38.6836997
				],
				[
				  35.082775,
				  38.6838078
				],
				[
				  35.0827042,
				  38.6838386
				],
				[
				  35.0826558,
				  38.68383
				],
				[
				  35.0826339,
				  38.6838383
				],
				[
				  35.0826364,
				  38.6838597
				],
				[
				  35.0827486,
				  38.6842578
				],
				[
				  35.0830314,
				  38.6846739
				],
				[
				  35.0833203,
				  38.6850636
				],
				[
				  35.0834969,
				  38.6855725
				],
				[
				  35.0836017,
				  38.6859761
				],
				[
				  35.0838994,
				  38.6869575
				],
				[
				  35.0844278,
				  38.6874119
				],
				[
				  35.0846989,
				  38.6877342
				],
				[
				  35.0848458,
				  38.6880531
				],
				[
				  35.0851072,
				  38.6885433
				],
				[
				  35.0852386,
				  38.6890192
				],
				[
				  35.0852675,
				  38.6894506
				],
				[
				  35.0851908,
				  38.6902175
				],
				[
				  35.0852161,
				  38.6912828
				],
				[
				  35.0852483,
				  38.6918569
				],
				[
				  35.0853444,
				  38.6922253
				],
				[
				  35.0854889,
				  38.6926942
				],
				[
				  35.0857033,
				  38.6931356
				],
				[
				  35.0859092,
				  38.6936283
				],
				[
				  35.0859322,
				  38.6940172
				],
				[
				  35.0859611,
				  38.6944567
				],
				[
				  35.0861053,
				  38.6947664
				],
				[
				  35.0863281,
				  38.6950533
				],
				[
				  35.0864017,
				  38.6952306
				],
				[
				  35.0864131,
				  38.6956975
				],
				[
				  35.0866058,
				  38.6961697
				],
				[
				  35.0866136,
				  38.6963572
				],
				[
				  35.0894828,
				  38.6982733
				],
				[
				  35.0894703,
				  38.6983108
				],
				[
				  35.0894647,
				  38.6983669
				],
				[
				  35.0894783,
				  38.6984928
				],
				[
				  35.0894803,
				  38.6986039
				],
				[
				  35.0894778,
				  38.6987436
				],
				[
				  35.08949,
				  38.6988581
				],
				[
				  35.0895208,
				  38.6989344
				],
				[
				  35.0895186,
				  38.6990614
				],
				[
				  35.0894567,
				  38.6992864
				],
				[
				  35.0893981,
				  38.6994739
				],
				[
				  35.0893744,
				  38.6995897
				],
				[
				  35.083716,
				  38.7011587
				],
				[
				  35.0769146,
				  38.701807
				],
				[
				  35.0723458,
				  38.702982
				],
				[
				  35.0649214,
				  38.7093834
				],
				[
				  35.062637,
				  38.7094644
				],
				[
				  35.0589508,
				  38.7072767
				],
				[
				  35.0515783,
				  38.7047647
				],
				[
				  35.0488266,
				  38.7049268
				],
				[
				  35.0446212,
				  38.7076413
				],
				[
				  35.0385987,
				  38.7075198
				],
				[
				  35.0364181,
				  38.7056966
				],
				[
				  35.0337702,
				  38.7055345
				],
				[
				  35.0317454,
				  38.7041164
				],
				[
				  35.0297206,
				  38.704157
				],
				[
				  35.0293571,
				  38.705575
				],
				[
				  35.0280073,
				  38.7056561
				],
				[
				  35.0263978,
				  38.704157
				],
				[
				  35.0224687,
				  38.7045758
				],
				[
				  35.017145,
				  38.6991352
				],
				[
				  35.011948,
				  38.6965631
				],
				[
				  35.0097052,
				  38.6940994
				],
				[
				  35.0068393,
				  38.6932889
				],
				[
				  35.0045133,
				  38.6947477
				],
				[
				  34.9980754,
				  38.6910196
				],
				[
				  34.9954587,
				  38.6913762
				],
				[
				  34.9933819,
				  38.6905982
				],
				[
				  34.9918867,
				  38.6905009
				],
				[
				  34.9821675,
				  38.6953961
				],
				[
				  34.9808384,
				  38.6948774
				],
				[
				  34.9799246,
				  38.6928027
				],
				[
				  34.9776472,
				  38.692259
				],
				[
				  34.9796409,
				  38.6875698
				],
				[
				  34.9794521,
				  38.6789576
				],
				[
				  34.981399,
				  38.674271
				],
				[
				  34.9822103,
				  38.6715476
				],
				[
				  34.9814802,
				  38.6693309
				],
				[
				  34.975396,
				  38.6649604
				],
				[
				  34.9749092,
				  38.6597028
				],
				[
				  34.9680138,
				  38.6597028
				],
				[
				  34.9702041,
				  38.655902
				],
				[
				  34.9706097,
				  38.6495667
				],
				[
				  34.9744931,
				  38.6439546
				],
				[
				  34.9773596,
				  38.6424823
				],
				[
				  34.9797498,
				  38.6403556
				],
				[
				  34.9829298,
				  38.6441066
				],
				[
				  34.9903283,
				  38.6402542
				],
				[
				  35.0002658,
				  38.6400166
				],
				[
				  35.0028009,
				  38.6412839
				],
				[
				  35.0081753,
				  38.6411255
				],
				[
				  35.011623,
				  38.6365315
				],
				[
				  35.015882,
				  38.6362147
				],
				[
				  35.018417,
				  38.6388285
				],
				[
				  35.0248055,
				  38.6388285
				],
				[
				  35.0270364,
				  38.6365315
				],
				[
				  35.0297742,
				  38.6358186
				],
				[
				  35.0348444,
				  38.637878
				],
				[
				  35.0398132,
				  38.6372444
				],
				[
				  35.0425511,
				  38.6345513
				],
				[
				  35.0458974,
				  38.6342344
				],
				[
				  35.0461002,
				  38.6358978
				],
				[
				  35.0516774,
				  38.6354226
				],
				[
				  35.0541111,
				  38.6389869
				],
				[
				  35.0575588,
				  38.6380365
				],
				[
				  35.0588771,
				  38.6400958
				],
				[
				  35.0667866,
				  38.6387493
				],
				[
				  35.0719158,
				  38.6393772
				]
			  ];

			var newData = [];

			for(var i = 0; i < data.length; i++){
				newData.push([data[i][1],data[i][0]]);
			}
			console.log(newData);
			var polygon = L.polygon(newData).addTo(self.map);

			if (opts.activeOnMove) {
				self.map.on('move', function (e) {
					self.setLocation(e.target.getCenter());
				});
			}

			//only adds closeBtn if not alwaysOpen
			if (opts.alwaysOpen !== true) {
				var xmap = L.control({ position: 'topright' });
				xmap.onAdd = function (map) {
					var btn_holder = L.DomUtil.create('div', 'leaflet-bar');
					var btn = L.DomUtil.create('a', 'leaflet-control ' + opts.className + '-close');
					btn.innerHTML = '&times;';
					btn_holder.appendChild(btn);
					L.DomEvent
						.on(btn, 'click', L.DomEvent.stop, self)
						.on(btn, 'click', self.closeMap, self);
					return btn_holder;
				};
				xmap.addTo(self.map);
			}

			if (opts.locationMarker)
				self.marker = buildMarker(self.location).addTo(self.map);

			return self.$map;
		}

		function buildMarker(loc) {
			var css = 'padding: 0px; margin: 0px; position: absolute; outline: 1px solid #fff; box-shadow: 1px 1px 3px rgba(0, 0, 0, 0.6);';

			return L.marker(parseLocation(loc) || L.latLng(0, 0), {
				icon: L.divIcon({
					className: opts.className + '-marker',
					iconAnchor: L.point(0, 0),
					html: '<div style="position: relative; top: -1px; left: -1px; padding: 0px; margin: 0px; cursor: crosshair;' +
						'width: ' + opts.cursorSize + '; height: ' + opts.cursorSize + ';">' +
						'<div style="width: 50%; height: 0px; left: -70%; border-top:  2px solid black;' + css + '"></div>' +
						'<div style="width: 50%; height: 0px; left:  30%; border-top:  2px solid black;' + css + '"></div>' +
						'<div style="width: 0px; height: 50%; top:   30%; border-left: 2px solid black;' + css + '"></div>' +
						'<div style="width: 0px; height: 50%; top:  -70%; border-left: 2px solid black;' + css + '"></div>' +
						'</div>',
				})
			});
		}

		$(this).each(function (index, input) {
			var self = this;

			self.$input = $(this);

			self.locationOri = self.$input.val();

			self.onChangeLocation = function () {
				var edata = {
					latlng: self.location,
					location: self.getLocation()
				};
				self.$input.trigger($.extend(edata, {
					type: 'changeLocation'
				}));
				opts.onChangeLocation.call(self, edata);
			};

			self.setLocation = function (loc, noSet) {
				loc = loc || defaults.location;
				console.log(loc);
				self.location = parseLocation(loc);

				if (self.marker)
					self.marker.setLatLng(loc);

				if (!noSet) {
					self.$input.data('location', self.location);
					self.$input.val(self.getLocation());
					self.onChangeLocation();
				}
			};

			self.getLocation = function () {
				return self.location ? L.Util.template(opts.locationFormat, {
					lat: self.location.lat,
					lng: self.location.lng,
					sep: opts.locationSep
				}) : self.location;
			};

			self.updatePosition = function () {
				switch (opts.position) {
					case 'bottomleft':
						self.$map.css({
							top: self.$input.offset().top + self.$input.height() + 6,
							left: self.$input.offset().left
						});
						break;
					case 'topright':
						self.$map.css({
							top: self.$input.offset().top,
							left: self.$input.offset().left + self.$input.width() + 5
						});
						break;
				}
			};

			self.openMap = function () {
				self.updatePosition();
				self.$map.show();
				self.map.invalidateSize();
				self.$input.trigger('show');
			};

			self.closeMap = function () {
				self.$map.hide();
				self.$input.trigger('hide');
			};

			self.setLocation(self.locationOri, true);

			self.$map = buildMap(self);

			self.$input
				.addClass(opts.className)
				.on('focus.' + opts.className, function (e) {
					e.preventDefault();
					self.openMap();
				})
				.on('blur.' + opts.className, function (e) {
					e.preventDefault();
					var p = e.relatedTarget;
					var close = true;
					while (p) {
						if (p._leaflet) {
							close = false;
							break;
						}
						p = p.parentElement;
					}
					if (close) {
						setTimeout(function () {
							self.closeMap();
						}, 100)
					}
				});

			$(window).on('resize', function () {
				if (self.$map.is(':visible'))
					self.updatePosition();
			});
			//opens map initially if alwaysOpen
			if (opts.alwaysOpen && opts.alwaysOpen === true) self.openMap();
		});

		return this;
	};

});
