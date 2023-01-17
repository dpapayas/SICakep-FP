<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<title>SI-CAKEP</title>
	<meta name="description" content="Latest updates and statistic charts">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<script src="https://ajax.googleapis.com/ajax/libs/webfont/1.6.16/webfont.js"></script>
	<script>
		WebFont.load({
			google: {"families":["Poppins:300,400,500,600,700","Roboto:300,400,500,600,700"]},
			active: function() {
				sessionStorage.fonts = true
			}
		});
	</script>
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" />
	<link href="<?= base_url('assets/plugins/global/plugins.bundle.css'); ?>" rel="stylesheet" type="text/css" />
	<link href="<?= base_url('assets/css/style.bundle.css'); ?>" rel="stylesheet" type="text/css" />
	<link href="<?= base_url('assets/plugins/custom/datatables/datatables.bundle.css'); ?>" rel="stylesheet" type="text/css" />
	<link rel="shortcut icon" href="<?= base_url('assets/img/favicon.png'); ?>" />
	<link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css"
	integrity="sha512-xodZBNTC5n17Xt2atTPuE1HxjVMSvLVW9ocqUKLsCC5CXdbqCmblAshOMAS6/keqq/sMZMZ19scR4PsZChSR7A=="
	crossorigin=""/>
	<script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"
	integrity="sha512-XQoYMqMTK8LvdxXYG3nZ448hOEQiglfqkJs1NOQV44cWnUrBc8PkAOcXy20w0vlaXaVUearIOBhiXZ5V3ynxwA=="
	crossorigin=""></script>
	<style type="text/css">
		.main-menu-container {
			position: absolute; 
			left: 0; 
			width: 47%;
		}
		.dataTables_scrollBody {
			overflow-x: hidden !important;
		}
		@media only screen and (max-width: 540px) {
			.main-menu-container {
				width: 100%;
				height: 100%;
			}
		}
		.info { 
			padding: 6px 8px; 
			font: 14px/16px Arial, Helvetica, sans-serif; 
			background: white; 
			background: rgba(255,255,255,0.8); 
			box-shadow: 0 0 15px rgba(0,0,0,0.2); 
			border-radius: 5px; 
		} 
		.info h4 { 
			margin: 0 0 5px; 
			color: #777; 
		}
		.legend { 
			text-align: left; 
			line-height: 18px; 
			color: #555; 
		}
		.legend i { 
			width: 18px; 
			height: 18px; 
			float: left; 
			margin-right: 8px; 
			opacity: 0.7; 
		}
		tr {
			vertical-align: baseline;
		}
		.leaflet-container .leaflet-popup-content-wrapper {
			border-radius: 0.475rem!important;
			text-align: left;
			box-shadow: 0 .5rem 1.5rem .5rem rgba(0,0,0,.075)!important;
		}
	</style>
	<script type="text/javascript">
		function imgError(image) {
			image.onerror = "";
			image.src = "<?= base_url('assets/img/not_found.png') ?>";
			return true;
		}
	</script>
</head>
<body style="overflow: hidden;">

	<div id="map" class="w-100 h-100" style="z-index: 0;overflow: hidden;"></div>

	<div class="main-menu-container">
		<div class="card">
			<div class="card-header">
				<div class="card-title">
					SI-CAKEP
				</div>
				<div class="card-toolbar">
					<div class="btn-group btn-group-sm">
						<a class="btn btn-primary" href="<?= base_url() ?>">
							<i class="bi bi-house"></i>
						</a>
						<button id="toggle-btn" class="btn btn-primary"><i class="bi bi-caret-down"></i></button>
					</div>
				</div>
			</div>
		</div>
		<div id="card-data" class="card" style="height: calc(100% - 70px);">
			<div class="card-body card-scroll">
				<div class="row">
					<div class="col-sm-2">
						<label class="col-form-label">
							Tahun
						</label>
						<select class="form-control" id="tahun">
							<?php foreach (range(1950, 2050) as $key => $value): ?>
								<option value="<?= $value ?>" <?= ($value==date('Y')) ? 'selected' : '' ?>><?= $value ?></option>
							<?php endforeach ?>
						</select>
					</div>
					<div class="col-sm-10">
						<label class="col-form-label">
							Layer
						</label>
						<div class=" d-flex mt-1">
							<div class="form-check form-check-custom form-check-solid me-5">
								<input class="form-check-input h-30px w-30px" type="checkbox" id="batas_adminsitrasi" checked>
								<label class="form-check-label" for="batas_adminsitrasi">Batas Administrasi</label>
							</div>
							<div class="form-check form-check-custom form-check-solid me-5">
								<input class="form-check-input h-30px w-30px" type="checkbox" id="jaringan_jalan">
								<label class="form-check-label" for="jaringan_jalan">Jaringan Jalan</label>
							</div>
							<div class="form-check form-check-custom form-check-solid me-5">
								<input class="form-check-input h-30px w-30px" type="checkbox" id="kontur">
								<label class="form-check-label" for="kontur">Kontur</label>
							</div>
							<div class="form-check form-check-custom form-check-solid me-5">
								<input class="form-check-input h-30px w-30px" type="checkbox" id="perairan">
								<label class="form-check-label" for="perairan">Perairan</label>
							</div>
						</div>
					</div>
					<div class="col-sm-6">
						<label class="col-form-label">
							SMART-I
						</label>
						<select id="input_kontrak" class="form-control" name="param" multiple="" tabindex="-1">
							<option value="PKP">
								[PKP] Kontrak Kerja Bidang Perumahan dan Kawasan Permukiman
							</option>
							<option value="PBL">
								[PBL] Kontrak Kerja Seksi Penataan Bangunan dan Lingkungan
							</option>
							<option value="PALD">
								[PALD] Kontrak Kerja UPT PALD
							</option>
							<option value="DRAINASE">
								[DRAINASE] Kontrak Kerja Seksi Drainase
							</option>
							<option value="JALAN">
								[JALAN] Kontrak Kerja Seksi Jalan
							</option>
							<option value="PJ">
								[PJ] Kontrak Kerja Seksi Penerangan Jalan
							</option>
							<option value="RUSUNAWA">
								[RUSUNAWA] Kontrak Kerja UPT Rusunawa
							</option>
						</select>
					</div>
					<div class="col-sm-6">
						<label class="col-form-label">
							Capaian Kinerja
						</label>
						<select id="input_capaian" class="form-control" name="param" multiple="multiple" tabindex="-1">
							<optgroup label="Seksi Jalan Bidang Bina Marga">
								<option value="0_0">Prasarana Jalan</option>
								<option value="0_1">Jembatan</option>
								<option value="0_2">Leger Jalan</option>
							</optgroup>
							<optgroup label="Seksi Drainase Bidang Bina Marga">
								<option value="1_0">Drainase</option>
								<option value="1_1">Genangan Air</option>
								<option value="1_2">Irigasi</option>
							</optgroup>
							<optgroup label="Seksi Penerangan Jalan Bina Marga">
								<option value="2_0">Penerangan Jalan Umum</option>
							</optgroup>
							<optgroup label="Bidang Cipta Karya">
								<option value="3_0">IPAL</option>
								<option value="3_1">HIPPAM</option>
								<option value="3_2">Gedung</option>
								<option value="3_3">SLF</option>
								<option value="3_4">RTBL</option>
							</optgroup>
							<optgroup label="UPT Pengolahan Air Limbah Daerah">
								<option value="4_0">IPLT</option>
								<!-- <option value="4_">MSS</option> -->
								<option value="4_1">Tengki Septic</option>
								<option value="4_2">LLTT</option>
							</optgroup>
							<optgroup label="Bidang Perumahan dan Kawasan Permukiman">
								<option value="5_0">RTLH</option>
								<option value="5_1">Bantuan PSU</option>
								<option value="5_2">Kawasan Kumuh</option>
							</optgroup>
							<optgroup label="UPT. Rusunawa">
								<option value="6_0">Rusunawa</option>
							</optgroup>
							<optgroup label="Bidang Tata Ruang dan Pertanahan">
								<option value="7_0">KRK</option>
								<option value="krk_mlg_barat">
									Pola Ruang RDTK Barat
								</option>
								<option value="krk_mlg_tengah">
									Pola Ruang RDTK Tengah
								</option>
								<option value="krk_mlg_tenggara">
									Pola Ruang RDTK Tenggara
								</option>
								<option value="krk_mlg_timur">
									Pola Ruang RDTK Timur
								</option>
								<option value="krk_mlg_timur_laut">
									Pola Ruang RDTK Timur Laut
								</option>
								<option value="krk_mlg_utara">
									Pola Ruang RDTK Utara
								</option>
							</optgroup>
						</select>
					</div>
					<div class="col-sm-6">
						<br />
						<div class="btn-group w-100 w-lg-50" data-kt-buttons="true" data-kt-buttons-target="[data-kt-button]">
							<label class="btn btn-outline-secondary text-muted text-hover-white text-active-white btn-outline btn-active-primary active" data-kt-button="true">
								<input class="btn-check" type="radio" name="tersedia" value="semua">Semua
							</label>
							<label class="btn btn-outline-secondary text-muted text-hover-white text-active-white btn-outline btn-active-primary" data-kt-button="true">
								<input class="btn-check" type="radio" name="tersedia" value="tersedia">Tersedia
							</label>
							<label class="btn btn-outline-secondary text-muted text-hover-white text-active-white btn-outline btn-active-primary" data-kt-button="true">
								<input class="btn-check" type="radio" name="tersedia" value="tidak">Tidak
							</label>
						</div>
					</div>
					<div class="col-sm-6">
						<br />
						<div class="d-flex align-items-center">
							<span class="bi bi-search position-absolute ms-6"></span>
							<input type="text" id="search" class="form-control form-control-solid w-250px ps-15" placeholder="Cari" />
						</div>
					</div>
					<div class="col-sm-12">
						<br/>
						<table class="table table-bordered" id="table" style="width: 100%; height:100%"></table>
					</div>
				</div>
			</div>
		</div>
	</div>

	<script src="<?= base_url('assets/plugins/global/plugins.bundle.js') ?>"></script>
	<script src="<?= base_url('assets/js/scripts.bundle.js') ?>"></script>
	<script src="<?= base_url('assets/plugins/custom/datatables/datatables.bundle.js') ?>"></script>
	<script src="<?= base_url('assets/js/leaflet.ajax.min.js') ?>" type="text/javascript"></script>
	<script src="<?= base_url('assets/js/google-layer.js') ?>" type="text/javascript"></script>
	<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDSYLMonOTm99fFiilHVj54qXeQy9pL5D8" defer></script>

	<script type="text/javascript">
		const inputTahun = $('#tahun')
		const table 	= $('#table').DataTable({
			lengthChange: false,
			scrollX: '10px',
			scrollY: '400px',
			language: {
				info: "_START_ - _END_ dari _TOTAL_",
				infoFiltered: "(Semua _MAX_)",
				infoEmpty: "-",
				zeroRecords: "Tidak ditemukan",
				emptyTable: "-",
				loadingRecords: "Memuat...",
				processing: "Memproses...",
				search: "Cari",
			},
			columns: [
			{ 
				title: '', data: 'name', sortable: false,
				render: function(data, type, row){
					const jenis = row['jenis'] ? `<span class="badge badge-primary mr-1">${row['jenis']}</span>` : ''
					const tersedia = !row['nomor_kontrak'] ? `<span class="badge badge-success mr-1">Tersedia</span>` : ''
					const kontrak_jenis = row['kontrak_jenis'] ? `<span class="badge badge-primary mr-1">${row['kontrak_jenis']}</span>` : ''
					const name 			= row['name'] ? `<span class="h5">${row['name']}</span>` : ''
					const kontraktor 	= row['kontraktor'] ? `<br/><span>Kontraktor: ${row['kontraktor']}</span>` : ''
					const nilai_kontrak = row['nilai_kontrak'] ? `<br/><span>Nilai Kontrak: ${row['nilai_kontrak']}</span>` : ''
					const nomor_kontrak = row['nomor_kontrak'] ? `<br/><span>Nomor: ${row['nomor_kontrak']}</span>` : ''
					const realisasi 	= row['realisasi'] ? `<br/><span>Realisasi: ${row['realisasi']}</span>` : ''
					const waktu_pengerjaan 	= row['waktu'] ? `<br/><span>Jangka Waktu Pengerjaan: ${row['waktu_pengerjaan']}</span>` : ''

					const panjang 	= row['panjang'] ? `<br/><span>Panjang: ${row['panjang']}km</span>` : ''
					const jalan_jembatan 	= row['jalan_jembatan'] ? `<br/><span>Jalan: ${row['jalan_jembatan']}</span>` : ''
					const jalan_pju 	= row['jalan_pju'] ? `<br/><span>Jalan: ${row['jalan_pju']}</span>` : ''
					const luas 	= row['luas'] ? `<br/><span>Luas: ${row['luas']}</span>` : ''
					const tahun_anggaran 	= row['tahun_anggaran'] ? `<br/><span>Tahun Anggaran: ${row['tahun_anggaran']}</span>` : ''
					const tahun_berdiri 	= row['tahun_berdiri'] ? `<br/><span>Tahun Berdiri: ${row['tahun_berdiri']}</span>` : ''
					const tahun_bangun 	= row['tahun_bangun'] ? `<br/><span>Tahun Bangun: ${row['tahun_bangun']}</span>` : ''
					const kelurahan 	= row['kelurahan'] ? `<br/><span>Kelurahan: ${row['kelurahan']}</span>` : ''
					const kecamatan 	= row['kecamatan'] ? `<br/><span>Kecamatan: ${row['kecamatan']}</span>` : ''
					const lampu 		= row['lampu'] ? `<br/><span>Jumlah Lampu: ${row['lampu']}</span>` : ''
					const alamat 		= row['alamat'] ? `<br/><span>Alamat: ${row['alamat']}</span>` : ''
					const rt 		= row['rt'] ? `<br/><span>RT ${row['rt']}</span>` : ''
					const rw 		= row['rw'] ? `<br/><span>RW ${row['rw']}</span>` : ''
					const kapasitas 		= row['kapasitas'] ? `<br/><span>Kapasitas: ${row['kapasitas']}</span>` : ''
					const jumlah 		= row['jumlah'] ? `<br/><span>Jumlah: ${row['jumlah']}</span>` : ''
					const bangunan 		= row['bangunan'] ? `<br/><span>Bangunan: ${row['bangunan']}</span>` : ''

					const col = row['latitude']!='0' && row['longitude']!='0' ? '10' : '12'
					const nav = row['latitude']!='0' && row['longitude']!='0' ? `<div class="col-2 justify-content-center align-self-center text-center">
					<span class="btn btn-success btn-sm" onclick="goto(${row['latitude']},${row['longitude']},${row['index']},'${row['name']}',${row['jumlah']},${row['bangunan']})">
					<i class="bi bi-geo-alt-fill"></i></span></div>` : ''

					return `<div class="row">
					<div class="col-${col}">
					${jenis}
					${tersedia}
					${kontrak_jenis}
					${name}
					${kontraktor}
					${nilai_kontrak}
					${nomor_kontrak}
					${realisasi}
					${waktu_pengerjaan}
					${panjang}
					${jalan_jembatan}
					${luas}
					${tahun_anggaran}
					${tahun_berdiri}
					${tahun_bangun}
					${kelurahan}
					${kecamatan}
					${lampu}
					${alamat}
					${rt}
					${rw}
					${kapasitas}
					${jumlah}
					${bangunan}
					</div>
					${nav}
					</div>`
				},
			},
			]
		})

		const target = document.querySelector("#map")
		const blockUI = new KTBlockUI(target, {
			message: '<div class="blockui-message"><span class="spinner-border text-primary"></span><div><span>Loading...</span<br/><br/><a href="#" onclick="batal()">Batal</a></div></div><br/>',
			overlayClass: "bg-primary bg-opacity-10",
			zIndex: 1,
		})

		function batal(){
			blockUI.release()
		}

		const kelurahanEvent = []
		$('#toggle-btn').click(e=>{
			const cardData = $('#card-data')
			if (cardData.is(":visible")) {
				cardData.toggle('hide')
				$('#toggle-btn').find('i').removeClass('bi-caret-down')
				$('#toggle-btn').find('i').addClass('bi-caret-up')
				if ($(window).width() < 540) {
					$('.main-menu-container').css('height','70px')
				}
			} else {
				cardData.toggle('show')
				$('#toggle-btn').find('i').removeClass('bi-caret-up')
				$('#toggle-btn').find('i').addClass('bi-caret-down')
				if ($(window).width() < 540) {
					$('.main-menu-container').css('height','100%')
				}
			}
		})

		$(window).resize(function() {
			if ($(window).width() > 540) {
				$('.main-menu-container').css('height','auto')
			}
		})

		let map, activeWindow
		let geojsonKec

		const info = L.control({position: 'bottomright'})
		var layers = []

		const icon = new L.Icon.Default()
		icon.options.shadowSize = [0,0]

		info.onAdd = function (map) {
			this._div = L.DomUtil.create('div', 'info')
			this.update()
			return this._div
		}

		info.update = function (props) {
			this._div.innerHTML = 
			(props ? `<h4>${props.KECAMATAN}<br>${props.KELURAHAN}`
				: 'Hover ke wilayah')
		}

		function goto(latitude,longitude,indexKRK,a,b,c) {
			if (latitude!=999 && longitude!=999) {
				map.setView([latitude, longitude], 18)
			} else {
				kelurahanEvent[indexKRK].fire('click')
				$('.kel'+(indexKRK+1)).html(`<h5>${a}</h5>Jumlah:${b}<br/>Bangunan:${c}`)
			}
		}


		function getColor(d) {
			return d == 'KEC. LOWOKWARU' ? '#42a5f5' :
			d == 'KEC. BLIMBING'  ? '#ef5350' :
			d == 'KEC. KLOJEN'  ? '#ffee58' :
			d == 'KEC. KEDUNGKANDANG'  ? '#66bb6a' :
			'#ab47bc'
		}

		function style(feature) {
			return {
				weight: 2,
				opacity: 1,
				color: 'white',
				dashArray: '',
				fillOpacity: 0.4,
				fillColor: getColor(feature.properties.KECAMATAN)
			}
		}

		function highlightFeature(e) {
			var layer = e.target

			layer.setStyle({
				fillOpacity: 0.8
			})

			info.update(layer.feature.properties)
		}

		function resetHighlight(e) {
			geojsonKec.resetStyle(e.target)
			info.update()
		}

		function zoomToFeature(e) {
			map.fitBounds(e.target.getBounds())
		}

		function onEachFeature(feature, layer) {
			layer.on({
				mouseover: highlightFeature,
				mouseout: resetHighlight,
				click: zoomToFeature
			})
			kelurahanEvent.push(layer)
			layer.bindPopup(`<div class="kel${feature.properties.OBJECTID}">${feature.properties.KELURAHAN}</div>`)
			layers.push(layer)
		}

		function loadKecLayer() {
			blockUI.block()
			$.getJSON("<?= base_url('assets/geojson/kelurahan.geojson') ?>")
			.then(function (data) {
				geojsonKec = L.geoJson(data, {
					onEachFeature: onEachFeature,
					style: style,
				})
				geojsonKec.addTo(map)
				blockUI.release()
			})
			.fail(function(err){
				blockUI.release()
				toastr.error("Kesalahan terdeteksi")
			})
		}


		function initMap() {
			var legend = L.control({position: 'bottomright'})

			legend.onAdd = function (map) {
				var div = L.DomUtil.create('div', 'info legend'),
				grades = ['KEC. LOWOKWARU', 'KEC. BLIMBING', 'KEC. KLOJEN', 'KEC. KEDUNGKANDANG', 'KEC. SUKUN'],
				labels = [], from, to

				for (var i = 0; i < grades.length; i++) {
					from = grades[i]
					to = grades[i + 1]

					labels.push('<i style="background:' + getColor(from) + '"></i> ' +from)
				}

				div.innerHTML = labels.join('<br>')
				return div
			}

			map = L.map('map').setView([-7.9666, 112.6326], 14)
			legend.addTo(map)
			info.addTo(map)
			map.zoomControl.setPosition('bottomright')

			L.gridLayer.googleMutant({
				type: 'roadmap'
			}).addTo(map)

			loadKecLayer()
		}

		$('#batas_adminsitrasi').change((e)=> {
			if (e.target.checked) {
				geojsonKec.addTo(map)
			} else{
				map.removeLayer(geojsonKec)
			}
		})

		function randomColor(){
			var color
			var r = Math.floor(Math.random() * 255)
			var g = Math.floor(Math.random() * 255)
			var b = Math.floor(Math.random() * 255)
			return "rgb("+0+" ,"+0+","+ b+")"
		}

		$(document).ready(function(){
			$('thead').hide()
			$('#input_kontrak').select2({
				placeholder: 'Pilih Kontrak',
			})
			$('#input_capaian').select2({
				placeholder: 'Pilih Bidang'
			})
			inputTahun.change(e=>{
				reqData($('#input_kontrak').val(),$('#input_capaian').val())
			})
			$('input[name="tersedia"]').change(e=>{
				reqData($('#input_kontrak').val(),$('#input_capaian').val())
			})
			$('#input_kontrak').change(e=>{
				reqData($('#input_kontrak').val(),$('#input_capaian').val())
			})
			$('#input_capaian').change(e=>{
				reqData($('#input_kontrak').val(),$('#input_capaian').val())
			})
			$('#search').on('keyup', function () {
				table.search(this.value).draw()
			})
			initMap()
		})

	</script>

