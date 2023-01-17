<script type="text/javascript">

	let jj_geojson

	function onEachJaringanJalan(feature, layer) {
		layer.bindPopup(`Nama Jalan: ${feature.properties.Nama_Jalan}<br>Fungsi: ${feature.properties.Fungsi}`)
	}

	$('#jaringan_jalan').change((e)=> {
		blockUI.block()
		if (e.target.checked){
			$.getJSON("<?= base_url('assets/geojson/jaringan_jalan.geojson') ?>")
			.then(function (data) {
				jj_geojson = L.geoJson(data, {
					onEachFeature: onEachJaringanJalan,
				})
				jj_geojson.addTo(map)
				blockUI.release()
				map.setZoom(18)
			})
			.fail(function(err){
				blockUI.release()
				toastr.error("Kesalahan terdeteksi")
			})
		} else{
			map.removeLayer(jj_geojson)
			blockUI.release()
		}
	})
</script>