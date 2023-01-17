<script type="text/javascript">
	const kontrak = new L.LayerGroup()
	const capaian = new L.LayerGroup()

	const krk1 = new L.LayerGroup()
	const krk2 = new L.LayerGroup()
	const krk3 = new L.LayerGroup()
	const krk4 = new L.LayerGroup()
	const krk5 = new L.LayerGroup()
	const krk6 = new L.LayerGroup()
	const krks = [krk1,krk2,krk3,krk4,krk5,krk6]

	function getColorZona(zona) {
		let color = "#feff4c"
		if ("Zona Perumahan"==zona) {
			color = "#feff4c"
		} else if ("Zona Fasilitas Umum"==zona) {
			color = "#ca9a46"
		} else if ("Zona RTH"==zona) {
			color = "#659f4b"
		} else if ("Zona Perdagangan"==zona) {
			color = "#ef4d48"
		} else if ("Zona Sempadan Sungai Rel."==zona) {
			color = "#669b4b"
		} else if ("Zona Militer"==zona) {
			color = "#73c151"
		} else if ("Zona Perkantoran"==zona) {
			color = "#a450bf"
		} else if ("Zona Sarana Pelayanan Umum"==zona) {
			color = "#ca9a46"
		} else if ("Zona Industri"==zona) {
			color = "#717171"
		} else if ("Zona Peruntukan Lainnya"==zona) {
			color = "#529c83"
		} else if ("Zona Peruntukan Khusus"==zona) {
			color = "#a8a8a8"
		} else if ("Zona Cagar Budaya"==zona) {
			color = "#659f4b"
		} else if ("Zona Ruang Terbuka Hijau"==zona) {
			color = "#659f4b"
		} else if ("Zona Perdagangan Dan Jasa"==zona) {
			color = "#ef4d48"
		} else if ("Zona Perlindungan Setempat"==zona) {
			color = "#73c151"
		} else if ("Zona Sarana Pelayanan Umum"==zona) {
			color = "#ca9a46"
		} else if ("Zona Industri"==zona) {
			color = "#717171"
		} else if ("Zona Peruntukan Lainnya"==zona) {
			color = "#529c83"
		} else if ("Zona Peruntukan Khusus"==zona) {
			color = "#a8a8a8"
		} else if ("Zona Cagar Budaya"==zona) {
			color = "#659f4b"
		} else if ("Zona Ruang Terbuka Hijau"==zona) {
			color = "#659f4b"
		} else if ("Zona Perdagangan Dan Jasa"==zona) {
			color = "#ef4d48"
		} else if ("Zona Perkantoran"==zona) {
			color = "#a450bf"
		} else if ("Zona Perlindungan Setempat"==zona) {
			color = "#73c151"
		}else if ("Zona Perumahan"==zona) {
			color = "#feff4c"
		} else if ("Zona Fasilitas Umum"==zona) {
			color = "#ca9a46"
		} else if ("Zona RTH"==zona) {
			color = "#659f4b"
		} else if ("Zona Perdagangan"==zona) {
			color = "#ef4d48"
		} else if ("Zona Sempadan Sungai Rel."==zona) {
			color = "#669b4b"
		} else if ("Zona Militer"==zona) {
			color = "#73c151"
		} else if ("Zona Perkantoran"==zona) {
			color = "#a450bf"
		} else if ("Zona Perumahan"==zona) {
			color = "#feff4c"
		} else if ("Zona Fasilitas Umum"==zona) {
			color = "#ca9a46"
		} else if ("Zona RTH"==zona) {
			color = "#659f4b"
		} else if ("Zona Perdagangan"==zona) {
			color = "#ef4d48"
		} else if ("Zona Sempadan Sungai Rel."==zona) {
			color = "#669b4b"
		} else if ("Zona Militer"==zona) {
			color = "#73c151"
		} else if ("Zona Perkantoran"==zona) {
			color = "#a450bf"
		} else  if ("Zona Perumahan"==zona) {
			color = "#feff4c"
		} else if ("Zona Fasilitas Umum"==zona) {
			color = "#ca9a46"
		} else if ("Zona RTH"==zona) {
			color = "#659f4b"
		} else if ("Zona Perdagangan"==zona) {
			color = "#ef4d48"
		} else if ("Zona Sempadan Sungai Rel."==zona) {
			color = "#669b4b"
		} else if ("Zona Militer"==zona) {
			color = "#73c151"
		} else if ("Zona Perkantoran"==zona) {
			color = "#a450bf"
		} else if ("Zona Sarana Pelayanan Umum"==zona) {
			color = "#ca9a46"
		} else if ("Zona Industri"==zona) {
			color = "#717171"
		} else if ("Zona Peruntukan Lainnya"==zona) {
			color = "#529c83"
		} else if ("Zona Peruntukan Khusus"==zona) {
			color = "#a8a8a8"
		} else if ("Zona Cagar Budaya"==zona) {
			color = "#659f4b"
		} else if ("Zona Ruang Terbuka Hijau"==zona) {
			color = "#659f4b"
		} else if ("Zona Perdagangan Dan Jasa"==zona) {
			color = "#ef4d48"
		} else if ("Zona Perlindungan Setempat"==zona) {
			color = "#73c151"
		} else if ("Perumahan"==zona) {
			color = "#feff4c"
		} else if ("Fasilitas Umum"==zona) {
			color = "#ca9a46"
		} else if ("RTH"==zona) {
			color = "#659f4b"
		} else if ("Perdagangan"==zona) {
			color = "#ef4d48"
		} else if ("Sempadan Sungai Rel."==zona) {
			color = "#669b4b"
		} else if ("Militer"==zona) {
			color = "#73c151"
		} else if ("Perkantoran"==zona) {
			color = "#a450bf"
		} else if ("Sarana Pelayanan Umum"==zona) {
			color = "#ca9a46"
		} else if ("Industri"==zona) {
			color = "#717171"
		} else if ("Peruntukan Lainnya"==zona) {
			color = "#529c83"
		} else if ("Peruntukan Khusus"==zona) {
			color = "#a8a8a8"
		} else if ("Cagar Budaya"==zona) {
			color = "#659f4b"
		} else if ("Ruang Terbuka Hijau"==zona) {
			color = "#659f4b"
		} else if ("Perdagangan Dan Jasa"==zona) {
			color = "#ef4d48"
		} else if ("Perlindungan Setempat"==zona) {
			color = "#73c151"
		}
		return color
	}

	function infoKontrak(item) {
		return `<table><tbody>
		<tr><td>Nama</td><td>:</td><td>${item['kontrak']}</td></tr>
		<tr><td>Kontraktor</td><td>:</td><td>${item['kontraktor']}</td></tr>
		<tr><td>Nilai Kontrak</td><td>:</td><td>${item['nilai_kontrak']}</td></tr>
		<tr><td>Nomor</td><td>:</td><td>${item['nomor_kontrak']}</td></tr>
		<tr><td>Realisasi</td><td>:</td><td>${item['realisasi']}</td></tr>
		<tr><td>Jangka Waktu Pengerjaan</td><td>:</td><td>${item['waktu'] ? item['waktu_pengerjaan'] : ''}</td></tr>
		</tbody></table>`
	}

	function reqData(jenis1, jenis2) {
		blockUI.block()
		kontrak.clearLayers()
		capaian.clearLayers()
		krks.forEach((item,index)=>{
			item.clearLayers()
		})

		map.removeLayer(kontrak)
		map.removeLayer(capaian)
		krks.forEach((item,index)=>{
			map.removeLayer(item)
		})

		table.rows().remove().draw()

		const requests = []
		requests.push($.ajax({
			url: '<?= base_url('index.php/api/data') ?>',
			type: 'POST',
			data: {
				jenis1: jenis1,
				jenis2: jenis2,
				tahun:inputTahun.val(),
				status_kontrak:$('label[data-kt-button="true"].active').find('input').val()
			}, success: function(response){
				let index_krk = 0
				response.forEach((item,index)=>{
					if (item['latitude']!=null && item['longitude']!=null) {
						if (item['latitude']!='0' && item['longitude']!='0') {
							const marker = L.marker([item['latitude'], item['longitude']],{icon: icon}).addTo(map)
							if (jenis1.includes(item['kontrak_jenis'])) {
								const info = infoKontrak(item)
								marker.bindPopup(info)
							} else if (item['capaian']=='0_0') {
								marker.bindPopup(`Nama: ${item['jalan']}<br/>Panjang:${item['panjang']}km`)
							} else if (item['capaian']=='0_1') {
								marker.bindPopup(`Nama: ${item['jembatan']}<br>Jalan: ${item['jalan_jembatan']}`)
							} else if (item['capaian']=='0_2') {
								marker.bindPopup(`Ruas: ${item['ruas']}<br>Jalan: ${item['jalan']}`)
							} else if (item['capaian']=='1_0') {
								const line = JSON.parse(item['line'])
								const polyline = L.polyline(line, {color: randomColor(),opacity:0.5,weight:5}).addTo(map)
								polyline.bindPopup(`Nama: ${item['drainase']}<br/>Panjang: ${item['panjang']}`)
								drainaseLayerGrp.addLayer(polyline)
							} else if (item['capaian']=='1_1') {
								marker.bindPopup(`Nama: ${item['lokasi']}`)
							} else if (item['capaian']=='1_2') {
								marker.bindPopup(`Nama: ${item['irigasi']}<br>Panjang: ${item['panjang']} m`)
							} else if (item['capaian']=='2_0') {
								marker.bindPopup(`No: ${item['no']}<br>Jalan: ${item['jalan_pju']}<br>Kelurahan: ${item['kelurahan'] ? item['kelurahan'] : ''}<br>Kecamatan: ${item['kecamatan'] ? item['kecamatan'] : ''}<br>Jumlah Lampu: ${item['lampu']}<br>`)
							} else if (item['capaian']=='3_0') {
								marker.bindPopup(`IPAL: ${item['ipal']}<br>Tahun Berdiri: ${item['tahun_berdiri']}<br>Alamat: ${item['alamat']}`)
							} else if (item['capaian']=='3_1') {
								marker.bindPopup(`HIPPAM: ${item['hippam']}<br>Tahun Bangun: ${item['tahun_bangun']}<br>Alamat: ${item['alamat']}`)
							} else if (item['capaian']=='3_2') {
								marker.bindPopup(`Nama: ${item['gedung']}<br>Alamat: ${item['alamat']}`)
							} else if (item['capaian']=='3_3') {
								marker.bindPopup(`Nama: ${item['gedung']}<br>Alamat: ${item['alamat']}`)
							} else if (item['capaian']=='3_4') {
								marker.bindPopup(`${item['gedung']}<br>Period: ${item['periode']}`)
							} else if (item['capaian']=='4_0') {
								marker.bindPopup(`Nama: ${item['iplt']}<br>Alamat: ${item['alamat']}`)
							} else if (item['capaian']=='4_1') {
								marker.bindPopup(`Alamat: ${item['alamat']}<br>RT: ${item['rt']}<br>RW: ${item['rw']}`)
							} else if (item['capaian']=='4_2') {
								marker.bindPopup(`Alamat: ${item['alamat']}<br>RT: ${item['rt']}<br>RW: ${item['rw']}`)
							} else if (item['capaian']=='5_0') {
								marker.bindPopup(`Nama: ${item['nama']}<br>Alamat: ${item['alamat']}`)
							} else if (item['capaian']=='5_1') {
								marker.bindPopup(`Nama: ${item['nama']}<br>Alamat: ${item['alamat']}`)
							} else if (item['capaian']=='6_0') {
								marker.bindPopup(`${item['lokasi']}<br>Alamat: ${item['alamat']}`)
							} else if (item['capaian']=='7_0') {
								response[index]['index'] = index_krk
								index_krk += 1
							}
							kontrak.addLayer(marker)
						}
					}
				})
				kontrak.addTo(map)
				table.rows.add(response).draw()
			},
			error: function(error){
				toastr.error('Terjadi kesalahan')
			},
		}))

		if (jenis2.includes('krk_mlg_barat')) {
			requests.push($.getJSON("<?= base_url('assets/geojson/krk_mlg_barat.geojson') ?>"))
		}
		if (jenis2.includes('krk_mlg_tengah')) {
			requests.push($.getJSON("<?= base_url('assets/geojson/krk_mlg_tengah.geojson') ?>"))
		}
		if (jenis2.includes('krk_mlg_tenggara')) {
			requests.push($.getJSON("<?= base_url('assets/geojson/krk_mlg_tenggara.geojson') ?>"))
		}
		if (jenis2.includes('krk_mlg_timur')) {
			requests.push($.getJSON("<?= base_url('assets/geojson/krk_mlg_timur.geojson') ?>"))
		}
		if (jenis2.includes('krk_mlg_timur_laut')) {
			requests.push($.getJSON("<?= base_url('assets/geojson/krk_mlg_timur_laut.geojson') ?>"))
		}
		if (jenis2.includes('krk_mlg_utara')) {
			requests.push($.getJSON("<?= base_url('assets/geojson/krk_mlg_utara.geojson') ?>"))
		}

		if (requests.length == 1) {
			requests[0].then(()=>{
				blockUI.release()
			})
		}

		if (requests.length > 1) {
			$.when.apply(undefined, requests)
			.done(function(a1,a2,a3,a4,a5,a6,a7) {

				const a = [a2,a3,a4,a5,a6,a7]
				a.forEach((item,index)=>{
					if (item) {
						krks[index] = L.geoJson(item[0], {
							onEachFeature: function (feature, layer) {
								if (item[0]['name']=='krk_mlg_barat') {
									layer.bindPopup(`Zona: ${feature.properties.Zona}`)
									layer.setStyle({color: getColorZona(feature.properties.Zona)})
								} else if (item[0]['name']=='krk_mlg_tengah') {
									layer.bindPopup(`Zona: ${feature.properties.Zona}`)
									layer.setStyle({color: getColorZona(feature.properties.Zona)})
								} else if (item[0]['name']=='krk_mlg_tenggara') {
									layer.bindPopup(`Zona: ${feature.properties.ZONA}`)
									layer.setStyle({color: getColorZona(feature.properties.ZONA)})
								} else if (item[0]['name']=='krk_mlg_timur') {
									layer.bindPopup(`Zona: ${feature.properties.R_Pola_Rua}`)
									layer.setStyle({color: getColorZona(feature.properties.R_Pola_Rua)})
								} else if (item[0]['name']=='krk_mlg_timur_laut') {
									layer.bindPopup(`Zona: ${feature.properties.Zona}`)
									layer.setStyle({color: getColorZona(feature.properties.Zona)})
								} else if (item[0]['name']=='krk_mlg_utara') {
									layer.bindPopup(`Zona: ${feature.properties.LAYER}`)
									layer.setStyle({color: getColorZona(feature.properties.LAYER)})
								}
							},
						})
						krks[index].addTo(map)
					}
				})
				blockUI.release()
			})
		}
	}

</script>