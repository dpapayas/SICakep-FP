<script type="text/javascript">

	let kontur_geojson

	function onEachKontur(feature, layer) {
		layer.bindPopup(`Sumber: ${feature.properties.Sumber}<br>Elevasi: ${feature.properties.ELEVATION}`)
	}

	$('#kontur').change((e)=> {
		blockUI.block()
		if (e.target.checked){
			$.getJSON("<?= base_url('assets/geojson/kontur.geojson') ?>")
			.then(function (data) {
				kontur_geojson = L.geoJson(data, {
					onEachFeature: onEachKontur,
				})
				kontur_geojson.addTo(map)
				blockUI.release()
				map.setZoom(18)
			})
			.fail(function(err){
				blockUI.release()
				toastr.error("Kesalahan terdeteksi")
			})
		} else{
			map.removeLayer(kontur_geojson)
			blockUI.release()
		}
	})
</script>