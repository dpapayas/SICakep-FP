<script type="text/javascript">

	let toponimi_geojson
	var toponimiLayerGrp = new L.LayerGroup()

	function onEachToponimi(feature, layer) {
		layer.bindPopup(`Nama Objek: ${feature.properties.Nama_Objek}<br>Koordinat: ${feature.properties.KOORDINAT}`)
		layer.setIcon(icon)
	}

	$('#toponimi').change((e)=> {
		blockUI.block()
		if (e.target.checked){
			toponimi_geojson = new L.GeoJSON.AJAX("<?= base_url('assets/geojson/toponimi.geojson') ?>",{
				onEachFeature: onEachToponimi
			})
			toponimiLayerGrp.addTo(map)
			toponimiLayerGrp.addLayer(toponimi_geojson)
		} else{
			toponimiLayerGrp.removeLayer(toponimi_geojson)
		}
		blockUI.release()
	})
</script>