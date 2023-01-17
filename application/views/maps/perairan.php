<script type="text/javascript">

	let perairan_geojson

	function onEachPerairan(feature, layer) {
		layer.bindPopup(`Klasifikasi: ${feature.properties.Klasifikas}<br>Zona: ${feature.properties.ZONA}`)
	}

	$('#perairan').change((e)=> {
		blockUI.block()
		if (e.target.checked){
			$.getJSON("<?= base_url('assets/geojson/perairan.geojson') ?>")
			.then(function (data) {
				perairan_geojson = L.geoJson(data, {
					onEachFeature: onEachPerairan,
				})
				perairan_geojson.addTo(map)
				blockUI.release()
				map.setZoom(18)
			})
			.fail(function(err){
				blockUI.release()
				toastr.error("Kesalahan terdeteksi")
			})
		} else{
			map.removeLayer(perairan_geojson)
			blockUI.release()
		}
	})
</script>