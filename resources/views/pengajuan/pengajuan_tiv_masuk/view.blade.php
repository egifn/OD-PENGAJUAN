@section('js')

<script type="text/javascript">
    function goBack() {
        window.history.back();
    }

    fetchAllData();
    function fetchAllData(){
        //let id = $(this).data('id_program');
        //let perusahaan = $(this).data('perusahaan');
        
        let perusahaan = $("#kode_perusahaan_tujuan").val();
		let kode_pengajuan = $("#kode_pengajuan").val();
        let id = $("#id_program").val();
		let tgl_import = $("#tgl_import").val();

        $.ajax({
        type: "GET",
        url: "{{ route('pengajuan_tiv/view_data_all.view_data_all') }}",
        data: {
             id: id,
			 kode_pengajuan: kode_pengajuan,
             perusahaan: perusahaan,
			 tgl_import: tgl_import
        },
        dataType: "json",
        success: function(response) {
            let tabledata_outlet;
            let totalReward = 0;
            let totalReward_tiv = 0;
            let totalPotongan = 0;
            let totalDitransfer = 0;
            let no = 0;
            response.data.forEach(program => {
                    let reward = program.reward;
                    //membuat format rupiah Harga//
                    var reverse_reward = reward.toString().split('').reverse().join(''),
                    ribuan_reward  = reverse_reward.match(/\d{1,3}/g);
                    rupiah_reward = ribuan_reward.join(',').split('').reverse().join('');
                    //End membuat format rupiah//

                    let reward_tiv = program.reward_tiv;
                    //membuat format rupiah Harga//
                    var reverse_reward_tiv = reward_tiv.toString().split('').reverse().join(''),
                    ribuan_reward_tiv  = reverse_reward_tiv.match(/\d{1,3}/g);
                    rupiah_reward_tiv = ribuan_reward_tiv.join(',').split('').reverse().join('');
                    //End membuat format rupiah//

                    let potongan = program.potongan;
                    //membuat format rupiah Harga//
                    var reverse_potongan = potongan.toString().split('').reverse().join(''),
                    ribuan_potongan  = reverse_potongan.match(/\d{1,3}/g);
                    rupiah_potongan = ribuan_potongan.join(',').split('').reverse().join('');
                    //End membuat format rupiah//

                    let ditransfer = program.ditransfer;
                    //membuat format rupiah Harga//
                    var reverse_ditransfer = ditransfer.toString().split('').reverse().join(''),
                    ribuan_ditransfer  = reverse_ditransfer.match(/\d{1,3}/g);
                    ditransfer_rupiah = ribuan_ditransfer.join(',').split('').reverse().join('');
                    //End membuat format rupiah//

                    let piutang_d = program.piutang_depo;
                    //membuat format rupiah Harga//
                    var reverse_piutang_d = piutang_d.toString().split('').reverse().join(''),
                    ribuan_piutang_d  = reverse_piutang_d.match(/\d{1,3}/g);
                    piutang_d_rupiah = ribuan_piutang_d.join(',').split('').reverse().join('');
                    //End membuat format rupiah//

                    let piutang_n = program.piutang_ng;
                    //membuat format rupiah Harga//
                    var reverse_piutang_n = piutang_n.toString().split('').reverse().join(''),
                    ribuan_piutang_n  = reverse_piutang_n.match(/\d{1,3}/g);
                    piutang_n_rupiah = ribuan_piutang_n.join(',').split('').reverse().join('');
                    //End membuat format rupiah//

                    let total_ditransfer = program.ditransfer - program.piutang_depo - program.piutang_ng;
                    //membuat format rupiah Harga//
                    var reverse_ttl_ditransfer = total_ditransfer.toString().split('').reverse().join(''),
                    ribuan_ttl_ditransfer  = reverse_ttl_ditransfer.match(/\d{1,3}/g);
                    ttl_ditransfer_rupiah = ribuan_ttl_ditransfer.join(',').split('').reverse().join('');
                    //End membuat format rupiah//

                    no = no + 1
                    tabledata_outlet += '<tr>';
                    tabledata_outlet += '<td>' +no+ '</td>';
                    tabledata_outlet += '<td class="id_program_detail" hidden>';
                        tabledata_outlet += program.id_program;
                    tabledata_outlet +='</td>';
                    tabledata_outlet += '<td class="perusahaan_detail">';
                        tabledata_outlet += program.perusahaan;
                        tabledata_outlet += '<input type="hidden" class="form-control" name="perusahaan_detail[]' + no +'" id="perusahaan_detail[]' + no +'" value="'+program.perusahaan+'">';
                    tabledata_outlet += '</td>';
                    tabledata_outlet += '<td class="dist_depo">';
                        tabledata_outlet += program.dist_depo;
                    tabledata_outlet += '</td>';
                    tabledata_outlet += '<td class="cluster">';
                        tabledata_outlet += program.cluster;
                    tabledata_outlet += '</td>';
                    tabledata_outlet += '<td class="customer_id">';
                        tabledata_outlet += program.customer_id;
                        tabledata_outlet += '<input type="hidden" class="form-control" name="customer_id[]' + no +'" id="customer_id[]' + no +'" value="'+program.customer_id+'">';
                    tabledata_outlet += '</td>';
                    tabledata_outlet += '<td class="customer_name">';
                        tabledata_outlet += program.customer_name;
                    tabledata_outlet += '</td>';
                    tabledata_outlet += '<td class="no_rek">';
                        tabledata_outlet += program.no_rek;
                    tabledata_outlet += '</td>';
                    tabledata_outlet += '<td class="bank">';
                        tabledata_outlet +=  program.bank;
                    tabledata_outlet += '</td>';
                    tabledata_outlet += '<td class="nama_rekening">';
                        tabledata_outlet += program.nama_rekening;
                    tabledata_outlet += '</td class="reward_dis">';
                    tabledata_outlet += '<td align="right">';
                        tabledata_outlet += rupiah_reward;
                        tabledata_outlet += '<input type="hidden" class="form-control" name="reward_dis[]' + no +'" id="reward_dis[]' + no +'" onclick="jumlah(' + no + ');" onkeyup="jumlah(' + no + ');" value="'+program.reward+'">';
                    tabledata_outlet += '</td>';
                    tabledata_outlet += '<td class="reward_tiv" align="right">';
                        tabledata_outlet += rupiah_reward_tiv;
                        tabledata_outlet += '<input type="hidden" class="form-control" name="reward_tiv[]' + no +'" id="reward_tiv[]' + no +'" onclick="jumlah(' + no + ');" onkeyup="jumlah(' + no + ');" value="'+program.reward_tiv+'">';
                    tabledata_outlet += '</td>';
                    tabledata_outlet += '<td class="reward_potongan" align="right">';
                        tabledata_outlet += rupiah_potongan;
                        tabledata_outlet += '<input type="hidden" class="form-control" name="reward_potongan[]' + no +'" id="reward_potongan[]' + no +'" onclick="jumlah(' + no + ');" onkeyup="jumlah(' + no + ');" value="'+program.potongan+'">';
                    tabledata_outlet += '</td>';
                    tabledata_outlet += '<td class="reward_transfer" align="right">';
                        tabledata_outlet += ditransfer_rupiah;
                        tabledata_outlet += '<input type="hidden" class="form-control" name="reward_transfer[]' + no +'" id="reward_transfer[]' + no +'" onclick="jumlah(' + no + ');" onkeyup="jumlah(' + no + ');" value="'+program.ditransfer+'">';
                    tabledata_outlet += '</td>';
                    
                    if($("#kode_divisi").val() == '16'){ //jika biaya
                        tabledata_outlet += '<td align="right">';
                            tabledata_outlet += piutang_d_rupiah;
                        tabledata_outlet += '</td>';
                        tabledata_outlet += '<td>';
                            tabledata_outlet += program.norek_depo;
                        tabledata_outlet += '</td>';
                        tabledata_outlet += '<td>';
                            tabledata_outlet += piutang_n_rupiah;
                        tabledata_outlet += '</td>';
                        tabledata_outlet += '<td>';
                            tabledata_outlet += program.norek_ng;
                        tabledata_outlet += '</td>';
                        tabledata_outlet += '<td align="right">';
                            tabledata_outlet += ttl_ditransfer_rupiah;
                        tabledata_outlet += '</td>';
                    }else if($("#kode_divisi").val() == '24'){ //jika Piutang
                        tabledata_outlet += '<td class="piutang_depo" align="right">';
                            tabledata_outlet += '<input type="text" class="form-control" style="width:150px;height:27px;text-align:right;" name="jml_depo[]' + no +'" id="jml_depo[]' + no +'" onkeyup="jumlah(' + no + ');" onkeydown="checkTab(' + no + ');" value="'+piutang_d_rupiah+'">';
                        tabledata_outlet += '</td>';
                        tabledata_outlet += '<td class="piutang_depo_temp" id="piutang_depo_temp' + no +'" contenteditable="true" hidden>';
                            tabledata_outlet += program.piutang_depo;
                        tabledata_outlet += '</td>';

                        tabledata_outlet += '<div class="input-group">';
                            tabledata_outlet += '<td class="no_rek_depo">';
                                tabledata_outlet += '<input type="text" name="no_rek_depo' + no +'" id="no_rek_depo' + no +'" onkeydown="checkTabCombo(' + no + ');" value="'+program.norek_depo+'" readonly>';
                                tabledata_outlet += '<span class="input-group-btn">';
                                tabledata_outlet += '<button type="button" class="btn btn-info btn-secondary" name="btn_depo' + no +'" id="btn_depo' + no +'" onclick="tombol(' + no + ');" data-toggle="modal" data-target="#myModalRekening" value = "'+no+'"><span class="fa fa-search"></span></button>';
                                tabledata_outlet += '</span>';
                            tabledata_outlet += '</div>';
                        tabledata_outlet += '</div>';

                        tabledata_outlet += '<td class="no_rek_depo_temp" id="no_rek_depo_temp' + no +'" hidden>';
                                tabledata_outlet += program.norek_depo;
                        tabledata_outlet += '</td>';

                        tabledata_outlet += '<td class="piutang_ng" align="right">';
                            tabledata_outlet += '<input type="text" class="form-control" style="width:150px;height:27px;text-align:right;" name="jml_ng[]' + no +'" id="jml_ng[]' + no +'" onkeyup="jumlah(' + no + ');" value="'+piutang_n_rupiah+'" readonly>';
                        tabledata_outlet += '</td>';
                        tabledata_outlet += '<td class="piutang_ng_temp" id="piutang_ng_temp' + no +'" contenteditable="true" hidden>';
                            tabledata_outlet += program.piutang_ng;
                        tabledata_outlet += '</td>';

                        tabledata_outlet += '<td class="no_rek_ng">';
                            tabledata_outlet += '<input type="text" class="form-control" style="width:150px;height:27px;" id="no_rek_ng' + no +'" id="no_rek_ng' + no +'" value="'+program.norek_ng+'" readonly>';
                        tabledata_outlet += '</div>';
                        
                        tabledata_outlet += '<td class="no_rek_ng_temp" id="no_rek_ng_temp' + no +'" hidden>';
                                tabledata_outlet += program.norek_ng;
                        tabledata_outlet += '</td>';

                        tabledata_outlet += '<td class="subtotal' + no +'" align="right">';
                            tabledata_outlet += ttl_ditransfer_rupiah;
                        tabledata_outlet += '</td>';
                    }else if($("#kode_divisi").val() == '30'){ //Non Gudang
                        tabledata_outlet += '<td class="piutang_depo" align="right">';
                        tabledata_outlet += '<input type="text" class="form-control" style="width:150px;height:27px;text-align:right;" name="jml_depo[]' + no +'" id="jml_depo[]' + no +'" onclick="jumlah(' + no + ');" onkeyup="jumlah(' + no + ');" value="'+piutang_d_rupiah+'" readonly>';
                        tabledata_outlet += '</td>';
                        tabledata_outlet += '<td class="piutang_depo_temp" id="piutang_depo_temp' + no +'" contenteditable="true" hidden>';
                                tabledata_outlet += program.piutang_depo;
                        tabledata_outlet += '</td>';

                        tabledata_outlet += '<td class="no_rek_depo">';
                            tabledata_outlet += '<input type="text" class="form-control" style="width:150px;height:27px;" id="no_rek_depo' + no +'" id="no_rek_depo' + no +'" value="'+program.norek_depo+'" readonly>';
                        tabledata_outlet += '</div>';
                        tabledata_outlet += '<td class="no_rek_depo_temp" id="no_rek_depo_temp' + no +'" hidden>';
                                tabledata_outlet += program.norek_depo;
                        tabledata_outlet += '</td>';

                        tabledata_outlet += '<td class="piutang_ng" align="right">';
                            tabledata_outlet += '<input type="text" class="form-control" style="width:150px;height:27px;text-align:right;" name="jml_ng[]' + no +'" id="jml_ng[]' + no +'" onkeyup="jumlah(' + no + ');" onkeydown="checkTab(' + no + ');" value="'+piutang_n_rupiah+'">';
                        tabledata_outlet += '</td>';
                        tabledata_outlet += '<td class="piutang_ng_temp" id="piutang_ng_temp' + no +'" contenteditable="true" hidden>';
                                tabledata_outlet += program.piutang_ng;
                        tabledata_outlet += '</td>';

                        tabledata_outlet += '<div class="input-group">';
                            tabledata_outlet += '<td class="no_rek_ng">';
                                tabledata_outlet += '<input type="text" id="no_rek_ng' + no +'" id="no_rek_ng' + no +'" onkeydown="checkTabCombo(' + no + ');" value="'+program.norek_ng+'" readonly>';
                                tabledata_outlet += '<span class="input-group-btn">';
                                tabledata_outlet += '<button type="button" class="btn btn-info btn-secondary" name="btn_ng' + no + '" id="btn_ng' + no + '" onclick="tombol(' + no + ');" data-toggle="modal" data-target="#myModalRekening" value = "'+no+'"><span class="fa fa-search"></span></button>';
                                tabledata_outlet += '</span>';
                            tabledata_outlet += '</div>';
                        tabledata_outlet += '</div>';

                        tabledata_outlet += '<td class="no_rek_ng_temp" id="no_rek_ng_temp' + no +'" hidden>';
                                tabledata_outlet += program.norek_ng;
                        tabledata_outlet += '</td>';

                        tabledata_outlet += '<td class="subtotal' + no +'" align="right">';
                            tabledata_outlet += ttl_ditransfer_rupiah;
                        tabledata_outlet += '</td>';
                    }else if($("#kode_divisi").val() == '6'){ //akunting
                        if($("#kode_sub_divisi").val() == '2'){
                            tabledata_outlet += '<td class="piutang_depo" align="right">';
                        tabledata_outlet += '<input type="text" class="form-control" style="width:150px;height:27px;text-align:right;" name="jml_depo[]' + no +'" id="jml_depo[]' + no +'" onkeyup="jumlah(' + no + ');" onkeydown="checkTab(' + no + ');" value="'+piutang_d_rupiah+'">';
                        tabledata_outlet += '</td>';
                        tabledata_outlet += '<td class="piutang_depo_temp" id="piutang_depo_temp' + no +'" contenteditable="true" hidden>';
                                tabledata_outlet += program.piutang_depo;
                        tabledata_outlet += '</td>';

                        tabledata_outlet += '<div class="input-group">';
                            tabledata_outlet += '<td class="no_rek_depo">';
                                tabledata_outlet += '<input type="text" name="no_rek_depo' + no +'" id="no_rek_depo' + no +'" onkeydown="checkTabCombo(' + no + ');" value="'+program.norek_depo+'" readonly>';
                                tabledata_outlet += '<span class="input-group-btn">';
                                tabledata_outlet += '<button type="button" class="btn btn-info btn-secondary" name="btn_depo' + no +'" id="btn_depo' + no +'" onclick="tombol(' + no + ');" data-toggle="modal" data-target="#myModalRekening" value = "'+no+'"><span class="fa fa-search"></span></button>';
                                tabledata_outlet += '</span>';
                            tabledata_outlet += '</div>';
                        tabledata_outlet += '</div>';

                        tabledata_outlet += '<td class="no_rek_depo_temp" id="no_rek_depo_temp' + no +'" hidden>';
                                tabledata_outlet += program.norek_depo;
                        tabledata_outlet += '</td>';

                        tabledata_outlet += '<td class="piutang_ng" align="right">';
                            tabledata_outlet += '<input type="text" class="form-control" style="width:150px;height:27px;text-align:right;" name="jml_ng[]' + no +'" id="jml_ng[]' + no +'" onclick="jumlah(' + no + ');" onkeyup="jumlah(' + no + ');" value="'+piutang_n_rupiah+'" readonly>';
                        tabledata_outlet += '</td>';
                        tabledata_outlet += '<td class="piutang_ng_temp" id="piutang_ng_temp' + no +'" contenteditable="true" hidden>';
                                tabledata_outlet += program.piutang_ng;
                        tabledata_outlet += '</td>';

                        tabledata_outlet += '<td class="no_rek_ng">';
                            tabledata_outlet += '<input type="text" class="form-control" style="width:150px;height:27px;" id="no_rek_ng' + no +'" id="no_rek_ng' + no +'" value="'+program.norek_ng+'" readonly>';
                        tabledata_outlet += '</div>';
                        tabledata_outlet += '<td class="no_rek_ng_temp" id="no_rek_ng_temp' + no +'" hidden>';
                                tabledata_outlet += program.norek_ng;
                        tabledata_outlet += '</td>';

                        tabledata_outlet += '<td class="subtotal' + no +'" align="right">';
                            tabledata_outlet += ttl_ditransfer_rupiah;
                        tabledata_outlet += '</td>';
                        }else{
                            // tabledata_outlet += '<td align="right">';
                            // tabledata_outlet += piutang_d_rupiah;
                            // tabledata_outlet += '</td>';
                            // tabledata_outlet += '<td>';
                            //     tabledata_outlet += program.norek_depo;
                            // tabledata_outlet += '</td>';
                            // tabledata_outlet += '<td>';
                            //     tabledata_outlet += piutang_n_rupiah;
                            // tabledata_outlet += '</td>';
                            // tabledata_outlet += '<td>';
                            //     tabledata_outlet += program.norek_ng;
                            // tabledata_outlet += '</td>';
                            // tabledata_outlet += '<td align="right">';
                            //     tabledata_outlet += ttl_ditransfer_rupiah;
                            // tabledata_outlet += '</td>';
                        }

                        
                    }
                    
                    tabledata_outlet += `</tr>`;

                    totalReward += program.reward;
                    totalReward_tiv += program.reward_tiv;
                    totalPotongan += parseInt(program.potongan);
                    totalDitransfer += program.ditransfer;
                });

                //membuat format rupiah totalReward//
                var reverse_totalReward = totalReward.toString().split('').reverse().join(''),
                    ribuan_totalReward  = reverse_totalReward.match(/\d{1,3}/g);
                    totalReward_rupiah = ribuan_totalReward.join(',').split('').reverse().join('');
                //End membuat format rupiah//

                //membuat format rupiah totalReward//
                var reverse_totalReward_tiv = totalReward_tiv.toString().split('').reverse().join(''),
                    ribuan_totalReward_tiv  = reverse_totalReward_tiv.match(/\d{1,3}/g);
                    totalReward_tiv_rupiah = ribuan_totalReward_tiv.join(',').split('').reverse().join('');
                //End membuat format rupiah//

                //membuat format rupiah totalPotongan//
                var reverse_totalPotongan = totalPotongan.toString().split('').reverse().join(''),
                    ribuan_totalPotongan  = reverse_totalPotongan.match(/\d{1,3}/g);
                    totalPotongan_rupiah = ribuan_totalPotongan.join(',').split('').reverse().join('');
                //End membuat format rupiah//

                //membuat format rupiah totalPotongan//
                var reverse_totalDitransfer = totalDitransfer.toString().split('').reverse().join(''),
                    ribuan_totalDitransfer  = reverse_totalDitransfer.match(/\d{1,3}/g);
                    totalDitransfer_rupiah = ribuan_totalDitransfer.join(',').split('').reverse().join('');
                //End membuat format rupiah//

                tabledata_outlet += `<tr>`;
                tabledata_outlet += `<td colspan="9" align='center'><b>T o t a l</b></td>`;
                tabledata_outlet += `<td align='right'><b>${totalReward_rupiah}</b></td>`;
                tabledata_outlet += `<td align='right'><b>${totalReward_tiv_rupiah}</b></td>`;
                tabledata_outlet += `<td align='right'><b>${totalPotongan_rupiah}</b></td>`;
                tabledata_outlet += `<td align='right'><b>${totalDitransfer_rupiah}</b></td>`;

                if($("#kode_divisi").val() == '24' || $("#kode_divisi").val() == '30' ){ //jika Piutang

                    tabledata_outlet += '<td class="total_pidepo" align="right">';
                    tabledata_outlet += '';
                    tabledata_outlet += '</td>';

                    tabledata_outlet += '<td>';
                        tabledata_outlet += '';
                    tabledata_outlet += '</td>';

                    tabledata_outlet += '<td class="total_ping" align="right">';
                        tabledata_outlet += '';
                    tabledata_outlet += '</td>';

                    tabledata_outlet += '<td>';
                        tabledata_outlet += '';
                    tabledata_outlet += '</td>';

                    tabledata_outlet += '<td class="total_subtotal" align="right">';
                        tabledata_outlet += '';
                    tabledata_outlet += '</td>';

                }else if($("#kode_divisi").val() == '6'){
                    if($("#kode_sub_divisi").val()== '2'){
                        tabledata_outlet += '<td class="total_pidepo" align="right">';
                        tabledata_outlet += '';
                        tabledata_outlet += '</td>';

                        tabledata_outlet += '<td>';
                            tabledata_outlet += '';
                        tabledata_outlet += '</td>';

                        tabledata_outlet += '<td class="total_ping" align="right">';
                            tabledata_outlet += '';
                        tabledata_outlet += '</td>';

                        tabledata_outlet += '<td>';
                            tabledata_outlet += '';
                        tabledata_outlet += '</td>';

                        tabledata_outlet += '<td class="total_subtotal" align="right">';
                            tabledata_outlet += '';
                        tabledata_outlet += '</td>';
                    }
                
                    
                }
    
                tabledata_outlet += `</tr>`;

                $("#tabledata_outlet").html(tabledata_outlet);
                $("#table_footer").html(table_footer);
        }
        });
    }

    function checkTab(no)
    {
        if (event.key === "Tab") {
            var modal = $('#pesanModal');
            var pesanText = $('#pesanText');

            var jml_depo_temp = ($("input[name='jml_depo[]" +no+ "']").val());
            //menghilangka format rupiah tambah_biaya//
            var temp_jml_depo_temp = jml_depo_temp.replace(/[.](?=.*?\.)/g, '');
            var temp_jml_depo_temp_jadi = parseInt(temp_jml_depo_temp.replace(/[^0-9.]/g,''));
            //End menghilangka format rupiah tambah_biaya//

            var jml_ng_temp = ($("input[name='jml_ng[]" +no+ "']").val());
            //menghilangka format rupiah tambah_biaya//
            var temp_jml_ng_temp = jml_ng_temp.replace(/[.](?=.*?\.)/g, '');
            var temp_jml_ng_temp_jadi = parseInt(temp_jml_ng_temp.replace(/[^0-9.]/g,''));
            //End menghilangka format rupiah tambah_biaya//
        
            
        }
    }

    function checkTabCombo(no)
    {
        var modal = $('#pesanModal');
        var pesanText = $('#pesanText');

        var jml_depo_temp = ($("input[name='jml_depo[]" +no+ "']").val());
        //menghilangka format rupiah tambah_biaya//
        var temp_jml_depo_temp = jml_depo_temp.replace(/[.](?=.*?\.)/g, '');
        var temp_jml_depo_temp_jadi = parseInt(temp_jml_depo_temp.replace(/[^0-9.]/g,''));
        //End menghilangka format rupiah tambah_biaya//

        var jml_ng_temp = ($("input[name='jml_ng[]" +no+ "']").val());
        //menghilangka format rupiah tambah_biaya//
        var temp_jml_ng_temp = jml_ng_temp.replace(/[.](?=.*?\.)/g, '');
        var temp_jml_ng_temp_jadi = parseInt(temp_jml_ng_temp.replace(/[^0-9.]/g,''));
        //End menghilangka format rupiah tambah_biaya//

        
    }

    function jumlah(no) {
        $("input[name='jml_depo[]" +no+ "']").maskMoney({thousands:',', decimal:'.', precision:0});
        $("input[name='jml_ng[]" +no+ "']").maskMoney({thousands:',', decimal:'.', precision:0});
        
        var total = ($("input[name='reward_transfer[]" +no+ "']").val());
        var piutang_depo = ($("input[name='jml_depo[]" +no+ "']").val());
        var piutang_ng = ($("input[name='jml_ng[]" +no+ "']").val());

        $('#piutang_depo_temp' + no + '').text(piutang_depo); 
        $('#piutang_ng_temp' + no + '').text(piutang_ng); 

        var jml_piutang_depo = parseInt($('#piutang_depo_temp' + no + '').text());
        var jml_piutang_ng = parseInt($('#piutang_ng_temp' + no + '').text()); 

        var jml_depo_temp = ($("input[name='jml_depo[]" +no+ "']").val());
        //menghilangka format rupiah tambah_biaya//
        var temp_jml_depo_temp = jml_depo_temp.replace(/[.](?=.*?\.)/g, '');
        var temp_jml_depo_temp_jadi = parseInt(temp_jml_depo_temp.replace(/[^0-9.]/g,''));
        //End menghilangka format rupiah tambah_biaya//

        var jml_ng_temp = ($("input[name='jml_ng[]" +no+ "']").val());
        //menghilangka format rupiah tambah_biaya//
        var temp_jml_ng_temp = jml_ng_temp.replace(/[.](?=.*?\.)/g, '');
        var temp_jml_ng_temp_jadi = parseInt(temp_jml_ng_temp.replace(/[^0-9.]/g,''));
        //End menghilangka format rupiah tambah_biaya//

        var subtotal = parseInt(total - temp_jml_depo_temp_jadi - temp_jml_ng_temp_jadi);
         //membuat format rupiah//
        var reverse = subtotal.toString().split('').reverse().join(''),
            ribuan  = reverse.match(/\d{1,3}/g);
            hasil_subtotal = ribuan.join(',').split('').reverse().join('');
        //End membuat format rupiah//

        $('.subtotal' + no + '').text(hasil_subtotal);
        
        // ////PERULANGAN UNTUK MENJUMLAH SUM TOTAL////
        // var table_piutang = document.getElementById("datatabel"), sumHsl_depo = 0;
        // for(var t = 1; t < table_piutang.rows.length; t++)
        // {
        //     //=====TOTAL Piutang =============================================//
        //     var depo = table_piutang.rows[t].cells[14].querySelector("input");
        //     if (depo) {
        //         // Mengambil nilai (teks) yang diinputkan dalam elemen input
        //         var inputValue = depo.value;
        //     }
        //     sumHsl_depo = sumHsl_depo + parseInt(inputValue);
        //     //membuat format rupiah total//
        //     var format_sumHsl_depo = sumHsl_depo.toString().split('').reverse().join(''),
        //         ribuan  = format_sumHsl_depo.match(/\d{1,3}/g);
        //         hasil_format_sumHsl_depo = ribuan.join(',').split('').reverse().join('');
        //     //End membuat format rupiah total//
        //     $('.total_pidepo').text(hasil_format_sumHsl_depo);
        // }
        
    }

    function tampilkan(no){
        var id_rek_depo = $('#no_rek_depo' + no + '').val();
        $('#no_rek_depo_temp' + no + '').text(id_rek_depo); 

        var id_rek_ng = $('#no_rek_ng' + no + '').val();
        $('#no_rek_ng_temp' + no + '').text(id_rek_ng); 
    }

    $(document).on("click", "#button_view_data", function(e) {
        e.preventDefault();
        // let id = $(this).data('id');
        let id = $(this).data('id_program');
		let kode_pengajuan = $(this).data('kode_pengajuan');
        let perusahaan = $(this).data('perusahaan');

        $.ajax({
        type: "GET",
        url: "{{ route('pengajuan_tiv/view_data_all.view_data_all') }}",
        data: {
             id: id,
			 kode_pengajuan: kode_pengajuan,
             perusahaan: perusahaan
        },
        dataType: "json",
        success: function(response) {
                let tabledata_list;
                let no = 0;
                response.data.forEach(program => {
                    let reward = program.reward;
                    //membuat format rupiah Harga//
                    var reverse_reward = reward.toString().split('').reverse().join(''),
                    ribuan_reward  = reverse_reward.match(/\d{1,3}/g);
                    rupiah_reward = ribuan_reward.join(',').split('').reverse().join('');
                    //End membuat format rupiah//

                    let potongan = program.potongan;
                    //membuat format rupiah Harga//
                    var reverse_potongan = potongan.toString().split('').reverse().join(''),
                    ribuan_potongan  = reverse_potongan.match(/\d{1,3}/g);
                    rupiah_potongan = ribuan_potongan.join(',').split('').reverse().join('');
                    //End membuat format rupiah//

                    let ditransfer = program.ditransfer;
                    //membuat format rupiah Harga//
                    var reverse_ditransfer = ditransfer.toString().split('').reverse().join(''),
                    ribuan_ditransfer  = reverse_ditransfer.match(/\d{1,3}/g);
                    ditransfer_rupiah = ribuan_ditransfer.join(',').split('').reverse().join('');
                    //End membuat format rupiah//

                    no = no + 1
                    tabledata_list += `<tr>`;
                    tabledata_list += `<td>` +no+ `</td>`;
                    tabledata_list += `<td hidden>${program.id_program}</td>`;
                    tabledata_list += `<td>${program.perusahaan}</td>`;
                    tabledata_list += `<td>${program.dist_depo}</td>`;
                    tabledata_list += `<td>${program.cluster}</td>`;
                    tabledata_list += `<td>${program.customer_id}</td>`;
                    tabledata_list += `<td>${program.cuastomer_name}</td>`;
                    tabledata_list += `<td>${program.no_rek}</td>`;
                    tabledata_list += `<td>${program.bank}</td>`;
                    tabledata_list += `<td>${program.nama_rekening}</td>`;
                    tabledata_list += `<td>${program.ach}</td>`;
                    tabledata_list += `<td alignt='right'>${rupiah_reward}</td>`;
                    tabledata_list += `<td alignt='right'>${rupiah_potongan}</td>`;
                    tabledata_list += `<td alignt='right'>${ditransfer_rupiah}</td>`;
                    tabledata_list += `</tr>`;
                });
                $("#tabledata_list").html(tabledata_list);
            }
        });
        $('#modalView').modal('show');
    });

    function input_ket() {
        var keterangan_detail = $("input[name='ket[]']").val();
        $('#keterangan_temp').text(keterangan_detail);
        $('#keterangan_header').val(keterangan_detail);
        $('#modal_keterangan_header').val(keterangan_detail);
       
    }

    $(document).ready(function(){
        fetch_data_rekening();
        function fetch_data_rekening(query = '')
        {
            $.ajax({
                url:'{{ route("pengajuan_tiv_masuk/action_rekening.actionRekening") }}',
                method:'GET',
                data:{query:query},
                dataType:'json',
                success:function(data)
                {
                    $('#lookup_rekening tbody').html(data.table_data);
                }
            })
        }

        $(document).on('keyup', '#search', function(){
            var query = $(this).val();
            fetch_data_rekening(query);
        });
    });

    //=============================================================================================
    let  baris= 0;
    function tombol(no){
        baris = $('#btn_depo' + no + '').val();
        baris_ng = $('#btn_ng' + no + '').val();
    }

    $(document).on('click', '.pilih_rekening', function (e) {
        if($("#kode_divisi").val() == '24'){ //jika Piutang
            document.getElementById('no_rek_depo'+baris+'').value = $(this).attr('data-norek');
            $('#no_rek_depo_temp'+baris+'').text($(this).attr('data-norek'));
        }else if($("#kode_divisi").val() == '30'){ //Non Gudang
            document.getElementById('no_rek_ng'+baris_ng+'').value = $(this).attr('data-norek');
            $('#no_rek_ng_temp'+baris_ng+'').text($(this).attr('data-norek'));
        }else if($("#kode_divisi").val() == '6'){ //akunting
            document.getElementById('no_rek_depo'+baris+'').value = $(this).attr('data-norek');
            $('#no_rek_depo_temp'+baris+'').text($(this).attr('data-norek'));
        } 

        $('#myModalRekening').modal('hide');
    });
    //=============================================================================================

    $("#button_form_approved").click(function() {
        let no_urut = $("#no_urut").val();

        let id_program = []
        let perusahaan = []
        let qty = []
        let harga = []
        let potongan = []
        let total = []
        let ket = []

        $('.id_program').each(function() {
            id_program.push($(this).text())
        })
        $('.perusahaan').each(function() {
            perusahaan.push($(this).text())
        })
        $('.qty').each(function() {
            qty.push($(this).text())
        })
        $('.harga').each(function() {
            harga.push($(this).text())
        })
        $('.potongan').each(function() {
            potongan.push($(this).text())
        })
        $('.total').each(function() {
            total.push($(this).text())
        })
        $('.keterangan_temp').each(function() {
            ket.push($(this).text())
        })

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            type: "POST",
            url: "{{ route('pengajuan_tiv_masuk/view/approved.approved') }}",
            data: {
                no_urut: no_urut,

                id_program: id_program,
                perusahaan: perusahaan,
                qty: qty,
                harga: harga,
                potongan: potongan,
                total: total,
                ket: ket,
            },
            success: function(response) {
                if(response.res === true) {
                    window.location.href = "{{ route('pengajuan_tiv_masuk.index')}}";
                }else{

                }
            }
        });
    });

    $("#button_form_update_pi").click(function() {
        let kode_pengajuan = $("#kode_pengajuan").val();
        let no_surat = $("#no_surat").val();
		let no_urut_pengajuan = $("#no_urut_pengajuan").val();

        let perusahaan_detail = []
        let id_toko = []
        let piutang_depo = []
        let norek_depo = []
        let piutang_ng = []
        let norek_ng = []
        let stopUpdate = false; // Flag untuk menghentikan proses update

        $('.perusahaan_detail').each(function() {
            perusahaan_detail.push($(this).text())
        })
        $('.customer_id').each(function() {
            id_toko.push($(this).text())
        })
        
        if($("#kode_divisi").val() == '24'){ //jika Piutang
            $('.piutang_depo_temp').each(function(index, element) {
                var modal = $('#pesanModal');
                var pesanText = $('#pesanText'); 
                
                let piutangTemp = parseFloat($(element).text());
                let norekTemp = $(".no_rek_depo_temp").eq(index).text();
                
            })
        }

        if($("#kode_divisi").val() == '6'){ //jika Piutang
            $('.piutang_depo_temp').each(function(index, element) {
                var modal = $('#pesanModal');
                var pesanText = $('#pesanText'); 
                
                let piutangTemp = parseFloat($(element).text());
                let norekTemp = $(".no_rek_depo_temp").eq(index).text();
                
            })
        }
        
        $('.piutang_depo_temp').each(function() {
            piutang_depo.push($(this).text())
        })

        $('.no_rek_depo_temp').each(function() {
            norek_depo.push($(this).text())
        })

        if($("#kode_divisi").val() == '30'){ //jika Piutang
            $('.piutang_ng_temp').each(function(index, element) {
                var modal = $('#pesanModal');
                var pesanText = $('#pesanText'); 

                let piutangTemp = parseFloat($(element).text());
                let norekTemp = $(".no_rek_ng_temp").eq(index).text();
                
            })
        }

        $('.piutang_ng_temp').each(function() {
            piutang_ng.push($(this).text())
        })
        $('.no_rek_ng_temp').each(function() {
            norek_ng.push($(this).text())
        })

        if (stopUpdate) {
            return; // Menghentikan proses update jika flag berubah menjadi true
        }

        $("button").prop("disabled", true);
        $("#loading").show();

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            type: "POST",
            url: "{{ route('pengajuan_tiv_masuk/store') }}",
            data: {
                kode_pengajuan: kode_pengajuan,
                no_surat: no_surat,
				no_urut_pengajuan: no_urut_pengajuan,

                perusahaan_detail: perusahaan_detail,
                id_toko: id_toko,
                piutang_depo: piutang_depo,
                norek_depo: norek_depo,
                piutang_ng: piutang_ng,
                norek_ng: norek_ng,
            },
            success: function(response) {
                $("#loading").hide();

                var modal = $('#pesanModal');
                var pesanText = $('#pesanText'); 

                if(response.res === true) {
                    pesanText.text('Update piutang berhasil');
                }else{
                    pesanText.text('Update piutang gagal');
                }
                modal.modal('show');
            },
            error: function() {
                // Menyembunyikan spinner jika terjadi error
                $("#loading").hide();
                alert('Terjadi kesalahan saat melakukan proses update.');
            },
            complete: function() {
                // Mengaktifkan kembali semua tombol setelah proses selesai
                $("button").prop("disabled", false);
            }
        });
    });

    $("#button_form_pending").click(function() {
        let no_urut = $("#no_urut").val();
    });

</script>

@stop

@extends('layouts.admin')

@section('title')
    <title>Pengajuan TIV</title>
@endsection

@section('content')


    
<main class="main">
    <link href="https://cdn.datatables.net/fixedcolumns/4.0.1/css/fixedColumns.dataTables.min.css" rel="stylesheet" type="text/css" />
    

    <style>
        #loading {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            z-index: 9999; /* Pastikan spinner berada di atas elemen lain */
            background-color: rgba(0, 0, 0, 0.5); /* Untuk memberikan latar belakang transparan */
            padding: 20px;
            border-radius: 5px;
        }
        
        .spinner {
            width: 40px;
            height: 40px;
            border: 5px solid rgba(0, 0, 0, 0.1); /* Warna border luar */
            border-top: 5px solid #3498db; /* Warna border atas untuk efek spinner */
            border-radius: 50%;
            animation: spin 1s linear infinite; /* Animasi berputar */
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
    </style>

    <ol class="breadcrumb">
        <li class="breadcrumb-item">Home</li>
        <li class="breadcrumb-item">Promo Penjualan</li>
        <li class="breadcrumb-item">Pengajuan Program</li>
        <li class="breadcrumb-item active">Pengajuan Program</li>
    </ol>
    <div class="container-fluid">

        <!-- <div id="loading" style="display: none;">
            <div class="spinner-border" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div> -->

        <div id="loading" style="display: none;">
            <div class="spinner"></div>
        </div>

        <div class="animated fadeIn">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-accent-primary">
                            <div class="card-header">
                                <h4 class="card-title">Tanggungan TIV - {{ $pengajuan_biaya_head->kode_pengajuan_b }}</h4>
                            </div>
                            <div class="card-body">
                                <div class="row" hidden>
                                    <div class="col-md-2 mb-2">
                                        Id User
                                        <input type="text" name="id_user" id="id_user" class="form-control" value="{{ Auth::user()->id }}" readonly>
                                    </div>

                                    <div class="col-md-2 mb-2">
                                        Nama User
                                        <input type="text" name="nama_user" id="nama_user" class="form-control" value="{{ Auth::user()->name }}" readonly>
                                    </div>

                                    <div class="col-md-2 mb-2">
                                        Kode Divisi
                                        <input type="text" name="kode_divisi" id="kode_divisi" class="form-control" value="{{ Auth::user()->kode_divisi }}" readonly>
                                        <input type="text" name="kode_sub_divisi" id="kode_sub_divisi" class="form-control" value="{{ Auth::user()->kode_sub_divisi }}" readonly>
                                    </div>

                                    <div class="col-md-3 mb-2">
                                        Kode Pengajuan
                                        <input type="text" name="kode_pengajuan" id="kode_pengajuan" class="form-control" value="{{ $pengajuan_biaya_head->kode_pengajuan_b }}" readonly>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-2 mb-2">
                                        Tgl Pengajuan
                                        <input type="text" name="tgl" id="tgl" class="form-control" value="{{ $pengajuan_biaya_head->tgl_pengajuan_b }}" readonly>
                                    </div>
									
									<div class="col-md-2 mb-2" hidden>
                                        Tgl Pengajuan Import
                                        <input type="text" name="tgl_import" id="tgl_import" class="form-control" value="{{ $pengajuan_biaya_head->tgl_import }}" readonly>
                                    </div>
									
									<div class="col-md-2 mb-2" hidden>
                                        No Urut Pengajuan
                                        <input type="text" name="no_urut_pengajuan" id="no_urut_pengajuan" class="form-control" value="{{ $pengajuan_biaya_head->no_urut_pengajuan }}" readonly>
                                    </div>

                                    <div class="col-md-3 mb-2">
                                        Diajukan Oleh
                                        <input type="text" name="nama" class="form-control" value="{{ $pengajuan_biaya_head->name }}" required readonly>
                                       
                                    </div>

                                    <div class="col-md-3 mb-2" hidden>
                                        Perusahaan
                                        <input type="text" name="perusahaan" class="form-control" value="{{ $pengajuan_biaya_head->nama_perusahaan }}" required readonly>
                                    </div>

                                    <div class="col-md-2 mb-2" hidden>
                                        Depo
                                        <input type="text" name="depo" class="form-control" value="{{ $pengajuan_biaya_head->nama_depo }}" required readonly>
                                    </div>

                                    <div class="col-md-5 mb-2">
                                        Nama Pengeluaran
                                        <input type="text" name="nm_pengeluaran" class="form-control" value="{{ $pengajuan_biaya_head->nama_pengeluaran }}" readonly>
                                    </div>

                                    <div class="col-md-2 mb-2">
                                        Untuk Perusahaan
                                        <input type="text" name="perusahaan_tujuan" class="form-control" value="{{ $pengajuan_biaya_head->perusahaan_tujuan }}" required readonly>
                                    </div>

                                    <div class="col-md-2 mb-2" hidden>
                                        Kode Untuk Perusahaan
                                        <input type="text" name="kode_perusahaan_tujuan" id="kode_perusahaan_tujuan" class="form-control" value="{{ $pengajuan_biaya_head->kode_perusahaan_tujuan }}" required readonly>
                                    </div>
                                </div>
                               
                                <div class="row">
                                    <div class="col-md-5 mb-2">
                                        Permintaan Pengajuan
                                        <input type="text" name="ket" class="form-control" value="{{ $pengajuan_biaya_head->keterangan }}" readonly>
                                    </div>

                                    <div class="col-md-5 mb-2">
                                        No Surat 
                                        <input type="text" name="no_surat" id="no_surat" class="form-control" value="{{ $pengajuan_biaya_head->no_surat_program }}" readonly>
                                    </div>

                                    <div class="col-md-2 mb-2">
                                        Id Program
                                        <input type="text" name="id_program" id="id_program" class="form-control" value="{{ $pengajuan_biaya_head->id_program }}" required readonly>
                                    </div>

                                    {{-- <div class="col-md-2 mb-2" hidden>
                                        Nama Program
                                        <input type="text" name="nama_program" id="nama_program" class="form-control" value="{{ $pengajuan_biaya_head->nama_program }}" required>
                                    </div> --}}

                                    <div class="col-md-2 mb-2" hidden>
                                        No Urut
                                        <input type="text" name="no_urut" id="no_urut" class="form-control" value="{{ $pengajuan_biaya_head->no_urut }}" required>
                                    </div>

                                    <div class="col-md-2 mb-2" hidden>
                                        keterangan
                                        <input type="text" name="keterangan_header" id="keterangan_header" class="form-control" value="" required>
                                    </div>
                                    
                                    {{-- <div class="col-md-2 mb-2" hidden>
                                        Jenis Surat
                                        <input type="text" name="jenis_surat" id="jenis_surat" class="form-control" value="" required>
                                    </div> --}}
                                </div>
                                
                                <div class="row" hidden>
                                    <div class="col-md-2 mb-2">
                                        Division
                                        <input type="text" name="divisi" class="form-control" value="{{ $pengajuan_biaya_head->nama_divisi }}" readonly>
                                       
                                    </div>

                                    <div class="col-md-2 mb-2">
                                        tipe
                                        <input type="text" name="tipe" class="form-control" value="" readonly>
                                       
                                    </div>
                                    
                                </div>

                                <div class="row">
                                    
                                </div>
                                
                            </div>

                        </div>
                    </div>

                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="col-md-12 mb-4">
                                        <div class="nav-tabs-boxed">
                                            <ul class="nav nav-tabs" role="tablist">
                                                <li class="nav-item">
                                                    <a class="nav-link active" data-toggle="tab" href="#pengajuan" role="tab" aria-controls="pengajuan">
                                                        <i class="nav-icon icon-folder"></i>
                                                        &nbsp;<b>Pengajuan</b>
                                                    </a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link" data-toggle="tab" href="#detail" role="tab" aria-controls="detail">
                                                        <i class="nav-icon icon-folder"></i>
                                                        &nbsp;<b>Detail Pengajuan</b>
                                                    </a>
                                                </li>
                                            </ul>

                                            <div class="tab-content">
                                                <div class="tab-pane active" id="pengajuan" role="tabpanel">
                                                    <br>

                                                    <div class="table-responsive">
                                                    <!--<div style="border:1px white;width:100%;height:200px;overflow-y:scroll;">-->
                                                        <table id="datatabel-v1" class="table table-bordered table-sm" style="white-space: nowrap; width:100%; margin-bottom: 0;">
                                                            <thead>
                                                                <tr>
                                                                    <th hidden>#</th>
                                                                    <th>Id Program</th>
                                                                    <th>Perusahaan</th>
                                                                    <th>Jml Toko</th>
                                                                    <th>Total Reward</th>
                                                                    <th>Total Potongan</th>
                                                                    <th>Total</th>
                                                                    <th>Keterangan</th>
                                                                    <th hidden>Aksi</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @forelse ($pengajuan_biaya_detail as $row)
                                                                <tr>
                                                                    <td hidden>#</td>
                                                                    <td class="id_program"><input type="hidden" name="id_program[]" class="form-control" value="{{ $row->description }}" readonly>{{ $row->description }}</td>
                                                                    <td class="perusahaan"><input type="hidden" name="perusahaan[]" class="form-control" value="{{ $row->spesifikasi }}" readonly>{{ $row->spesifikasi }}</td>
                                                                    <td class="qty" align="right"><input type="hidden" name="qty[]" class="form-control" value="{{ $row->qty }}" readonly>{{ $row->qty }}</td>
                                                                    <td class="harga" align="right"><input type="hidden" name="harga[]" class="form-control" value="{{ $row->harga }}" readonly>Rp. {{ number_format($row->harga)}}</td>
                                                                    <td class="potongan" align="right"><input type="hidden" name="potongan[]" class="form-control" value="{{ $row->potongan }}" readonly>Rp. {{ number_format($row->potongan)}}</td>
                                                                    <td class="total" align="right"><input type="hidden" name="total[]" class="form-control" value="{{ $row->tharga }}" readonly>Rp. {{ number_format($row->tharga)}}</td>
                                                                    @if(Auth::user()->kode_divisi == '10' or Auth::user()->kode_divisi == '2') <!--claim-->
                                                                        @if($row->status_detail_clm == '0') <!-- Baru -->
                                                                            <td class="ket" align="right"><input type="text" name="ket[]" class="form-control" onkeyup="input_ket();" value="" required></td>
                                                                        @elseif($row->status_detail_clm == '1') <!-- approved -->
                                                                            <td class="ket" align="right"><input type="text" name="ket[]" class="form-control" onkeyup="input_ket();" value="{{ $row->keterangan_detail_clm }}" readonly></td>
                                                                        @elseif($row->status_detail_clm == '2') <!-- denied -->
                    
                                                                        @elseif($row->status_detail_clm == '3') <!-- pending -->
                                                                            <td class="ket" align="right"><input type="text" name="ket[]" class="form-control" onkeyup="input_ket();" value="{{ $row->keterangan_detail_clm }}" required></td>
                                                                        @endif
                                                                    @elseif(Auth::user()->kode_divisi == '24') <!--Piutang-->
                                                                        @if($row->status_detail_piutang == '0') <!-- Baru -->
                                                                            <td class="ket" align="right"><input type="text" name="ket[]" class="form-control" onkeyup="input_ket();" value="" required></td>
                                                                        @elseif($row->status_detail_piutang == '1') <!-- approved -->
                                                                            <td class="ket" align="right"><input type="text" name="ket[]" class="form-control" onkeyup="input_ket();" value="{{ $row->keterangan_detail_piutang }}" readonly></td>
                                                                        @elseif($row->status_detail_piutang == '2') <!-- denied -->
                    
                                                                        @elseif($row->status_detail_piutang == '3') <!-- pending -->
                                                                            <td class="ket" align="right"><input type="text" name="ket[]" class="form-control" onkeyup="input_ket();" value="{{ $row->keterangan_detail_piutang }}" required></td>
                                                                        @endif
                                                                    @elseif(Auth::user()->kode_divisi == '6') <!--Piutang Akunting-->
                                                                        @if($row->status_detail_piutang == '0') <!-- Baru -->
                                                                            <td class="ket" align="right"><input type="text" name="ket[]" class="form-control" onkeyup="input_ket();" value="" required></td>
                                                                        @elseif($row->status_detail_piutang == '1') <!-- approved -->
                                                                            <td class="ket" align="right"><input type="text" name="ket[]" class="form-control" onkeyup="input_ket();" value="{{ $row->keterangan_detail_piutang }}" readonly></td>
                                                                        @elseif($row->status_detail_piutang == '2') <!-- denied -->
                    
                                                                        @elseif($row->status_detail_piutang == '3') <!-- pending -->
                                                                            <td class="ket" align="right"><input type="text" name="ket[]" class="form-control" onkeyup="input_ket();" value="{{ $row->keterangan_detail_piutang }}" required></td>
                                                                        @endif
                                                                    @elseif(Auth::user()->kode_divisi == '30') <!--Non Gudang-->
                                                                        @if($row->status_detail_ng == '0') <!-- Baru -->
                                                                            <td class="ket" align="right"><input type="text" name="ket[]" class="form-control" onkeyup="input_ket();" value="" required></td>
                                                                        @elseif($row->status_detail_ng == '1') <!-- approved -->
                                                                            <td class="ket" align="right"><input type="text" name="ket[]" class="form-control" onkeyup="input_ket();" value="{{ $row->keterangan_detail_ng }}" readonly></td>
                                                                        @elseif($row->status_detail_ng == '2') <!-- denied -->
                    
                                                                        @elseif($row->status_detail_ng == '3') <!-- pending -->
                                                                            <td class="ket" align="right"><input type="text" name="ket[]" class="form-control" onkeyup="input_ket();" value="{{ $row->keterangan_detail_ng }}" required></td>
                                                                        @endif
                                                                    @elseif(Auth::user()->kode_divisi == '16') <!--Biaya-->
                                                                        @if($row->status_detail == '0') <!-- Baru -->
                                                                            <td class="ket" align="right"><input type="text" name="ket[]" class="form-control" onkeyup="input_ket();" value="" required></td>
                                                                        @elseif($row->status_detail == '1') <!-- approved -->
                                                                            <td class="ket" align="right"><input type="text" name="ket[]" class="form-control" onkeyup="input_ket();" value="{{ $row->keterangan_detail }}" readonly></td>
                                                                        @elseif($row->status_detail == '2') <!-- denied -->
                    
                                                                        @elseif($row->status_detail == '3') <!-- pending -->
                                                                            <td class="ket" align="right"><input type="text" name="ket[]" class="form-control" onkeyup="input_ket();" value="{{ $row->keterangan_detail }}" required></td>
                                                                        @endif
                                                                    @endif
                                                                    <td align="center" hidden>
                                                                        <button type="button" data-id="{{ $row->description }}" data-perusahaan="{{ $row->spesifikasi }}" id="button_view_data" class="btn btn-success btn-sm">View</button>
                                                                    </td>
                                                                    <td class="keterangan_temp" id="keterangan_temp" hidden></td>
                                                                </tr>
                                                                @empty
                                                                <tr>
                                                                    
                                                                </tr>
                                                                @endforelse               
                                                            </tbody>
                                                        </table>
                                                    <!--</div>-->
                                                    </div>
                                                    <br>
                                                        
                                                    <div class="row">
                                                        <div class="col-md-8 mb-2">
                                                            <div class="input-group mb-3">
                                                                    
                                                                <table class="table table-bordered table-striped table-sm" id="tabelinput">
                                                                    <tbody>
                                                                        <?php $no=1 ?>
                                                                        @forelse ($approval_upload as $row)
                                                                        <tr>
                                                                            <td><i>Attachment_{{ $no }}</i></td>
                                                                            <td>
                                                                                <a href="{{ route('pengajuan/download.download', ['filename' => $row->filename]) }}">
                                                                                    {{ $row->filename }}
                                                                                </a> 
                                                                                    
                                                                            </td>
                                                                        </tr>
                                                                        <?php $no++ ?>
                                                                        @empty
                                                                            
                                                                        @endforelse
                                                                    </tbody>
                                                                </table>
                    
                                                            </div>
                                                        </div>
                    
                                                        <div class="col-md-2 mb-2">
                                                            <label class="float-right" style="font-size:20px; ">Total Rp.</label>
                                                        </div>  
                                                        <div class="col-md-2 mb-2">
                                                            <input type="text" name="total_harga" id="total_harga" class="form-control" value="Rp. {{ number_format($pengajuan_biaya_detail_total) }}" style="text-align:right; font-style:bold;" required readonly>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-md-12 mb-2">
                                                            <div class="input-group mb-3">
                                                                    
                                                                <table class="table table-bordered table-striped table-sm" id="tabelinput">
                                                                    <tbody>
                                                                        <?php $no=1 ?>
                                                                        @forelse ($pengajuan_biaya_upload as $row)
                                                                        <tr>
                                                                            <td><i>Attachment_{{ $no }}</i></td>
                                                                            <td>
                                                                                <a href="{{ route('pengajuan/download.download', ['filename' => $row->filename]) }}">
                                                                                    {{ $row->filename }}
                                                                                </a> 
                                                                                    
                                                                            </td>
                                                                        </tr>
                                                                        <?php $no++ ?>
                                                                        @empty
                                                                            
                                                                        @endforelse
                                                                    </tbody>
                                                                </table>
                    
                                                            </div>
                                                        </div>
                                                    </div>
                       
                                                    <div class="row">     
                                                        <div class="col-md-12 mb-2">
                                                            <button class="btn btn-primary btn-sm float-right" onclick="goBack()">K e m b a l i</button>
                                                               
                                                            @if(Auth::user()->kode_divisi == '10' or Auth::user()->kode_divisi == '2') <!--Claim-->
                                                                @if($pengajuan_biaya_head->status_validasi_clm  == '1') <!-- 2: approved -->
                                                                    <button type="submit" id="savedatas" name="savedatas" class="btn btn-success btn-sm" disabled>Verifikasi</button>
                                                                    <button type="submit" id="savedatas" name="savedatas" class="btn btn-warning btn-sm" disabled>Pending</button>
                                                                            
                                                                @elseif($pengajuan_biaya_head->status_validasi_clm == '2') <!-- 3: denied -->
                                                                    <button type="submit" id="savedatas" name="savedatas" class="btn btn-success btn-sm" disabled>Verifikasi</button>
                                                                    <button type="submit" id="savedatas" name="savedatas" class="btn btn-warning btn-sm" disabled>Pending</button>
                                                                            
                                                                @elseif($pengajuan_biaya_head->status_validasi_clm == '3') <!-- 4: Pending -->
                                                                    <button class="btn btn-success btn-sm" id="button_form_approved">Verifikasi</button>
                                                                    <button class="btn btn-warning btn-sm" id="button_form_pending">Pending</button>
                                                                            
                                                                @else
                                                                    <button class="btn btn-success btn-sm" id="button_form_approved">Verifikasi</button>
                                                                    {{-- <button class="btn btn-warning btn-sm" id="button_form_pending">Pending</button> --}}
                                                                    <button type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#modal_pending">
                                                                        Pending
                                                                    </button>
                                                                @endif
                                                            @elseif(Auth::user()->kode_divisi == '24') <!--Piutang-->
                                                                @if($pengajuan_biaya_head->status_validasi_piutang  == '1') <!-- 2: approved -->
                                                                    <button type="submit" id="savedatas" name="savedatas" class="btn btn-success btn-sm" disabled>Verifikasi</button>
                                                                    <button type="submit" id="savedatas" name="savedatas" class="btn btn-warning btn-sm" disabled>Pending</button>
                                                                            
                                                                @elseif($pengajuan_biaya_head->status_validasi_piutang == '2') <!-- 3: denied -->
                                                                    <button type="submit" id="savedatas" name="savedatas" class="btn btn-success btn-sm" disabled>Verifikasi</button>
                                                                    <button type="submit" id="savedatas" name="savedatas" class="btn btn-warning btn-sm" disabled>Pending</button>
                                                                            
                                                                @elseif($pengajuan_biaya_head->status_validasi_piutang == '3') <!-- 4: Pending -->
                                                                    <button class="btn btn-success btn-sm" id="button_form_approved">Verifikasi</button>
                                                                    <button class="btn btn-warning btn-sm" id="button_form_pending">Pending</button>
                                                                            
                                                                @else
                                                                    <button class="btn btn-success btn-sm" id="button_form_approved">Verifikasi</button>
                                                                    <button class="btn btn-warning btn-sm" id="button_form_pending">Pending</button>
                                                                @endif
                                                            @elseif(Auth::user()->kode_divisi == '6') <!--Piutang Akunting-->
                                                                @if(Auth::user()->kode_sub_divisi == '2')
                                                                    @if($pengajuan_biaya_head->status_validasi_piutang  == '1') <!-- 2: approved -->
                                                                        <button type="submit" id="savedatas" name="savedatas" class="btn btn-success btn-sm" disabled>Verifikasi</button>
                                                                        <button type="submit" id="savedatas" name="savedatas" class="btn btn-warning btn-sm" disabled>Pending</button>
                                                                                
                                                                    @elseif($pengajuan_biaya_head->status_validasi_piutang == '2') <!-- 3: denied -->
                                                                        <button type="submit" id="savedatas" name="savedatas" class="btn btn-success btn-sm" disabled>Verifikasi</button>
                                                                        <button type="submit" id="savedatas" name="savedatas" class="btn btn-warning btn-sm" disabled>Pending</button>
                                                                                
                                                                    @elseif($pengajuan_biaya_head->status_validasi_piutang == '3') <!-- 4: Pending -->
                                                                        <button class="btn btn-success btn-sm" id="button_form_approved">Verifikasi</button>
                                                                        <button class="btn btn-warning btn-sm" id="button_form_pending">Pending</button>
                                                                                
                                                                    @else
                                                                        <button class="btn btn-success btn-sm" id="button_form_approved">Verifikasi</button>
                                                                        <button class="btn btn-warning btn-sm" id="button_form_pending">Pending</button>
                                                                    @endif
                                                                @else
                                                                    @if($pengajuan_biaya_head->status_validasi == '1') <!-- 2: approved -->
                                                                        <button type="submit" id="savedatas" name="savedatas" class="btn btn-success btn-sm" disabled>Verifikasi</button>
                                                                        <button type="submit" id="savedatas" name="savedatas" class="btn btn-warning btn-sm" disabled>Pending</button>
                                                                                
                                                                    @elseif($pengajuan_biaya_head->status_validasi == '2') <!-- 3: denied -->
                                                                        <button type="submit" id="savedatas" name="savedatas" class="btn btn-success btn-sm" disabled>Verifikasi</button>
                                                                        <button type="submit" id="savedatas" name="savedatas" class="btn btn-warning btn-sm" disabled>Pending</button>
                                                                                
                                                                    @elseif($pengajuan_biaya_head->status_validasi == '3') <!-- 4: Pending -->
                                                                        <button class="btn btn-success btn-sm" id="button_form_approved">Verifikasi</button>
                                                                        <button class="btn btn-warning btn-sm" id="button_form_pending">Pending</button>
                                                                                
                                                                    @else
                                                                        <button class="btn btn-success btn-sm" id="button_form_approved">Verifikasi</button>
                                                                        <button class="btn btn-warning btn-sm" id="button_form_pending">Pending</button>
                                                                    @endif
                                                                @endif
                                                                
                                                            @elseif(Auth::user()->kode_divisi == '30') <!--Non Gudang-->
                                                                @if($pengajuan_biaya_head->status_validasi_ng  == '1') <!-- 2: approved -->
                                                                    <button type="submit" id="savedatas" name="savedatas" class="btn btn-success btn-sm" disabled>Verifikasi</button>
                                                                    <button type="submit" id="savedatas" name="savedatas" class="btn btn-warning btn-sm" disabled>Pending</button>
                                                                            
                                                                @elseif($pengajuan_biaya_head->status_validasi_ng == '2') <!-- 3: denied -->
                                                                    <button type="submit" id="savedatas" name="savedatas" class="btn btn-success btn-sm" disabled>Verifikasi</button>
                                                                    <button type="submit" id="savedatas" name="savedatas" class="btn btn-warning btn-sm" disabled>Pending</button>
                                                                            
                                                                @elseif($pengajuan_biaya_head->status_validasi_ng == '3') <!-- 4: Pending -->
                                                                    <button class="btn btn-success btn-sm" id="button_form_approved">Verifikasi</button>
                                                                    <button class="btn btn-warning btn-sm" id="button_form_pending">Pending</button>
                                                                            
                                                                @else
                                                                    <button class="btn btn-success btn-sm" id="button_form_approved">Verifikasi</button>
                                                                    <button class="btn btn-warning btn-sm" id="button_form_pending">Pending</button>
                                                                @endif
                                                            @elseif(Auth::user()->kode_divisi == '16') <!--Biaya-->
                                                                @if($pengajuan_biaya_head->status_validasi == '1') <!-- 2: approved -->
                                                                    <button type="submit" id="savedatas" name="savedatas" class="btn btn-success btn-sm" disabled>Verifikasi</button>
                                                                    <button type="submit" id="savedatas" name="savedatas" class="btn btn-warning btn-sm" disabled>Pending</button>
                                                                            
                                                                @elseif($pengajuan_biaya_head->status_validasi == '2') <!-- 3: denied -->
                                                                    <button type="submit" id="savedatas" name="savedatas" class="btn btn-success btn-sm" disabled>Verifikasi</button>
                                                                    <button type="submit" id="savedatas" name="savedatas" class="btn btn-warning btn-sm" disabled>Pending</button>
                                                                            
                                                                @elseif($pengajuan_biaya_head->status_validasi == '3') <!-- 4: Pending -->
                                                                    <button class="btn btn-success btn-sm" id="button_form_approved">Verifikasi</button>
                                                                    <button class="btn btn-warning btn-sm" id="button_form_pending">Pending</button>
                                                                            
                                                                @else
                                                                    <button class="btn btn-success btn-sm" id="button_form_approved">Verifikasi</button>
                                                                    <button class="btn btn-warning btn-sm" id="button_form_pending">Pending</button>
                                                                @endif
                                                            @elseif(Auth::user()->kode_sub_divisi == '13') <!--ASM-->
                                                                        
                                                            @else
                                                                        
                                                            @endif
                                                               
                                                        </div>
                                                    </div>
                                                        
                                                    <div class="modal fade" id="modalTambahPesan_approve" tabindex="-1" aria-labelledby="modalTambahPesan_approve" aria-hidden="true">
                                                        <div class="modal-dialog">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title">Isi untuk Keterangan</h5>
                                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <!--FORM TAMBAH BARANG-->
                                                                    <form action="{{ route('pengajuan_tiv/update', $pengajuan_biaya_head->no_urut) }}" method="get">
                                                                        @csrf
                                                                        <div class="form-group">
                                                                            <input type="hidden" name="modal_no_urut" id="modal_no_urut" class="form-control" value="{{ $pengajuan_biaya_head->no_urut }}" required readonly>
                                                                            <label>keterangan</label>
                                                                            <textarea name="addKeterangan" id="addKeterangan" cols="10" rows="5" class="form-control" required></textarea>
                                                                        </div>
                                                                        <button type="submit" class="btn btn-primary btn-sm float-right">S i m p a n</button>
                                                                    </form>
                                                                    <!--END FORM TAMBAH BARANG-->
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                        
                                                    <div class="modal fade" id="modalTambahPesan_denied" tabindex="-1" aria-labelledby="modalTambahPesan_denied" aria-hidden="true">
                                                        <div class="modal-dialog">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title">Isi untuk Keterangan..</h5>
                                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <!--FORM TAMBAH BARANG-->
                                                                    <form action="{{ route('pengajuan_tiv/denied', $pengajuan_biaya_head->no_urut) }}" method="get">
                                                                        @csrf
                                                                        <div class="form-group">
                                                                            <input type="hidden" name="modal_no_urut" id="modal_no_urut" class="form-control" value="{{ $pengajuan_biaya_head->no_urut }}" required readonly>
                                                                            <label>keterangan</label>
                                                                            <textarea name="addKeterangan" id="addKeterangan" cols="10" rows="5" class="form-control" required></textarea>
                                                                        </div>
                                                                        <button type="submit" class="btn btn-primary btn-sm float-right">S i m p a n</button>
                                                                    </form>
                                                                    <!--END FORM TAMBAH BARANG-->
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="tab-pane" id="detail" role="tabpanel">
                                                    <br>
                                                    <div class="table-responsive">
                                                    <!--<div style="border:1px white;width:100%;height:200px;overflow-y:scroll;">-->
                                                        <table id="datatabel" class="table table-bordered table-sm" style="white-space: nowrap; width:100%; margin-bottom: 0;">
                                                            <thead>
                                                                <tr>
                                                                    <th>No</th>
                                                                    <th hidden>Id</th>
                                                                    <th>Perusahaan</th>
                                                                    <th>Depo</th>
                                                                    <th>Cluster</th>
                                                                    <th>Id Toko</th>
                                                                    <th>Nama Toko</th>
                                                                    <th>No Rek</th>
                                                                    <th>Bank</th>
                                                                    <th>Nama Rekening</th>
                                                                    <th>Reward Distributor</th>
                                                                    <th>Reward TIV</th>
                                                                    <th>Potongan</th>
                                                                    <th>Total</th>
                                                                    @if(Auth::user()->kode_divisi == '24' || Auth::user()->kode_divisi == '30' || Auth::user()->kode_divisi == '16') <!-- Jika Piutang, akunting dan Non Gudang -->
                                                                        <th>Piutang Depo</th>
                                                                        <th>No rek Depo</th>
                                                                        <th>Piutang NG</th>
                                                                        <th>No Rek NG</th>
                                                                        <th>Sub Total</th>
                                                                    @elseif(Auth::user()->kode_divisi == '6')
                                                                        @if(Auth::user()->kode_sub_divisi == '2')
                                                                            <th>Piutang Depo</th>
                                                                            <th>No rek Depo</th>
                                                                            <th>Piutang NG</th>
                                                                            <th>No Rek NG</th>
                                                                            <th>Sub Total</th>
                                                                        @endif
                                                                    @endif
                                                                </tr>
                                                            </thead>
                                                            <tbody id="tabledata_outlet">
                                                                
                                                            </tbody>
                                                            <tfoot id="table_footer">

                                                            </tfoot>
                                                        </table>
                                                    </div>
                                                    <br>
                                                    <div class="row">     
                                                        <div class="col-md-12 mb-2">
                                                            @if(Auth::user()->kode_divisi == '24') <!--Piutang-->
                                                                @if($pengajuan_biaya_head->status_validasi_piutang  == '1') <!-- 2: approved -->
                                                                    <button type="button" id="savedatas" name="savedatas" class="btn btn-success btn-sm" disabled>Update Piutang</button>
                                                                            
                                                                @elseif($pengajuan_biaya_head->status_validasi_piutang == '2') <!-- 3: denied -->
                                                                    <button type="button" id="savedatas" name="savedatas" class="btn btn-success btn-sm" disabled>Update Piutang</button>
                                                                            
                                                                @elseif($pengajuan_biaya_head->status_validasi_piutang == '3') <!-- 4: Pending -->
                                                                    <button type="button" class="btn btn-success btn-sm" id="button_form_update_pi">Update Piutang</button>
                                                                            
                                                                @else
                                                                    <button type="button" class="btn btn-success btn-sm" id="button_form_update_pi">Update Piutang</button>
                                                                @endif
                                                            @elseif(Auth::user()->kode_divisi == '6') <!--Piutang Akunting-->
                                                                @if(Auth::user()->kode_sub_divisi == '2')
                                                                    @if($pengajuan_biaya_head->status_validasi_piutang  == '1') <!-- 2: approved -->
                                                                        <button type="button" id="savedatas" name="savedatas" class="btn btn-success btn-sm" disabled>Update Piutang</button>
                                                                                
                                                                    @elseif($pengajuan_biaya_head->status_validasi_piutang == '2') <!-- 3: denied -->
                                                                        <button type="button" id="savedatas" name="savedatas" class="btn btn-success btn-sm" disabled>Update Piutang</button>
                                                                                
                                                                    @elseif($pengajuan_biaya_head->status_validasi_piutang == '3') <!-- 4: Pending -->
                                                                        <button type="button" class="btn btn-success btn-sm" id="button_form_update_pi">Update Piutang</button>
                                                                                
                                                                    @else
                                                                        <button type="button" class="btn btn-success btn-sm" id="button_form_update_pi">Update Piutang</button>
                                                                    @endif
                                                                @endif
                                                                
                                                            @elseif(Auth::user()->kode_divisi == '30') <!--Non Gudang-->
                                                                @if($pengajuan_biaya_head->status_validasi_ng  == '1') <!-- 2: approved -->
                                                                    <button type="button" id="savedatas" name="savedatas" class="btn btn-success btn-sm" disabled>Update Piutang</button>
                                                                            
                                                                @elseif($pengajuan_biaya_head->status_validasi_ng == '2') <!-- 3: denied -->
                                                                    <button type="button" id="savedatas" name="savedatas" class="btn btn-success btn-sm" disabled>Update Piutang</button>
                                                                            
                                                                @elseif($pengajuan_biaya_head->status_validasi_ng == '3') <!-- 4: Pending -->
                                                                    <button type="button" class="btn btn-success btn-sm" id="button_form_update_pi">Update Piutang</button>
                                                                            
                                                                @else
                                                                    <button type="button" class="btn btn-success btn-sm" id="button_form_update_pi">Update Piutang</button>
                                                                @endif                   
                                                            @endif
                                                               
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                </div>                
            
        </div>
    </div>
</main>

<div id="pesanModal" class="modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Status</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <p id="pesanText"></p>
            </div>
        </div>
    </div>
</div>

<div class="modal fade bd-example-modal-lg" id="myModalRekening" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document" >
        <div class="modal-content" style="background: #fff;">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Data Rekening</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="#" method="get">
                    <div class="input-group mb-3 col-md-6 float-right">
                        <input type="text" name="search" id="search" class="form-control" placeholder="Cari Rekening . . .">
                    </div>
                </form>
                <div style="border:1px white;width:100%;height:470px;overflow-y:scroll;">
                    <table id="lookup_rekening" class="table table-bordered table-hover table-striped">
                        <thead>
                            <tr>
                                <th>No Rekening</th>
                                <th>Perusahaan</th>
                                <th>Bank</th>
                                <th>Keterangan</th>
                            </tr>
                        </thead>
                        <tbody>
                            
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="pesanModal" tabindex="-1" role="dialog" aria-labelledby="pesanModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="pesanModalLabel">Pesan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p id="pesanText"></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal_pending" tabindex="-1" aria-labelledby="modal_pending" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Pilih penerima</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!--FORM TAMBAH BARANG-->
                <form action="{{ route('pengajuan_tiv_masuk/pending', $pengajuan_biaya_head->no_urut) }}" method="get">
                    @csrf
                    <div class="form-group">
                        <input type="hidden" name="modal_no_urut" id="modal_no_urut" class="form-control" value="{{ $pengajuan_biaya_head->no_urut }}" required readonly>
                        <input type="hidden" name="modal_kode_perusahaan" id="modal_kode_perusahaan" class="form-control" value="{{ $pengajuan_biaya_head->kode_perusahaan_tujuan }}" required readonly>
                        <input type="hidden" name="modal_kode_pengajuan_b" id="modal_kode_pengajuan_b" class="form-control" value="{{ $pengajuan_biaya_head->kode_pengajuan_b }}" required readonly>
                        <input type="hidden" name="modal_no_surat" id="modal_no_surat" class="form-control" value="{{ $pengajuan_biaya_head->no_surat_program }}" required readonly>
                        <input type="hidden" name="modal_id_program" id="modal_id_program" class="form-control" value="{{ $pengajuan_biaya_head->id_program }}" required readonly>
                        <input type="hidden" name="modal_keterangan_header" id="modal_keterangan_header" class="form-control" value="" required readonly>

                        <label><input type="checkbox" name="penerima_ssd" id="penerima_ssd" value="SSD"> SSD</label>
                        &nbsp;
                        &nbsp;
                        &nbsp;
                        &nbsp;
                        <label><input type="checkbox" name="penerima_control" id="penerima_control" value="CLAIM CONTROLLER"> CLAIM CONTROLLER</label><br>
                        {{-- <label for="">keterangan</label>
                        <textarea name="addKeterangan" id="addKeterangan" cols="10" rows="2" class="form-control"></textarea> --}}
                    </div>
                    <hr>
                    <button type="submit" class="btn btn-warning btn-sm float-right">P r o s e s</button>
                </form>
                <!--END FORM TAMBAH BARANG-->
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalView" tabindex="-1" aria-labelledby="modalView" aria-hidden="true" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content" style="background: #fff;">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Daftar Peserta</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="#" method="get">
                    <div class="input-group mb-3 col-md-4 float-right" hidden>
                        <input type="text" name="cari_list" id="cari_list" class="form-control" value="">
                    </div>
                </form>
                <div style="border:1px white;width:100%;height:470px;overflow-y:scroll;">
                    <table id="lookup_list" class="table table-bordered table-hover table-striped">
                        <thead>
                            <tr>
                                <th >No</th>
                                <th hidden>Id</th>
                                <th >Perusahaan</th>
                                <th >Depo</th>
                                <th >Cluster</th>
                                <th >Id Toko</th>
                                <th >Nama Toko</th>
                                <th >No Rek</th>
                                <th >Bank</th>
                                <th >Nama Rekening</th>
                                <th >Qty</th>
                                <th >Reward TIV</th>
                                <th >Potongan</th>
                                <th >Total</th>
                            </tr>
                        </thead>
                        <tbody id="tabledata_list">

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade bd-example-modal-lg" id="myModalKategori" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document" >
        <div class="modal-content" style="background: #fff;">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Nama Pengeluaran</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="#" method="get">
                    <div class="input-group mb-3 col-md-6 float-right">
                        <input type="text" name="search_category" id="search_category" class="form-control" placeholder="Cari Pengeluaran . . .">
                    </div>
                </form>
                <div style="border:1px white;width:100%;height:470px;overflow-y:scroll;">
                    <table id="lookup_category" class="table table-bordered table-hover table-striped">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>Nama Pengeluaran</th>
                                <th>Sifat</th>
                            </tr>
                        </thead>
                        <tbody>
                            
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade bd-example-modal-lg" id="myModalCoa" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document" >
        <div class="modal-content" style="background: #fff;">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">C O A</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="#" method="get" hidden>
                    <div class="input-group mb-3 col-md-6 float-right">
                        <input type="text" name="search_coa" id="search_coa" class="form-control" placeholder="Search Data . . .">
                    </div>
                </form>
                <div style="border:1px white;width:100%;height:470px;overflow-y:scroll;">
                    <table id="lookup_coa" class="table table-bordered table-hover table-striped">
                        <thead>
                            <tr>
                                <th>Account Id</th>
                                <th>Account Name</th>
                            </tr>
                        </thead>
                        <tbody>
                            
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade bd-example-modal-lg" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document" >
        <div class="modal-content" style="background: #fff;">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Daftar Claim</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="#" method="get">
                    <div class="input-group mb-3 col-md-6 float-right">
                        <input type="text" name="search" id="search" class="form-control" placeholder="Cari Data . . .">
                    </div>
                </form>
                <div style="border:1px white;width:100%;height:470px;overflow-y:scroll;">
                <table id="lookup" class="table table-bordered table-hover table-striped">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Area</th>
                            <th>Nama Toko</th>
                            <th>No Rekening</th>
                            <th>Bank</th>
                            <th>Pemilik</th>
                            <th>Qty</th>
                            <th>Reward</th>
                            <th>Total</th>
                            <th>Potongan</th>
                        </tr>
                    </thead>
                    <tbody>
                       
                    </tbody>
                </table>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('script')

    <!-- UNTUK TABLE -->
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.3/js/dataTables.bootstrap5.min.js"></script>

    <script src="https://cdn.datatables.net/fixedcolumns/4.0.1/js/dataTables.fixedColumns.min.js"></script>
    <script>
        // DataTable
        $(document).ready(function() {
            var table = $('#datatabel-v1').DataTable({
                dom: '<"top"i>rt<"bottom"flp><"clear">',
                bInfo: false,
                bFilter: false,
                lengthChange: false,
                scrollY: "355px",
                scrollX: "355px",
                scrollCollapse: true,
                paging: false,
                pageLength: 20,
                fixedColumns: {
                    left: 0,
                    right: 0,
                },
            });
            // $('#searchbox').on('keyup', function() {
            //     table.search(this.value).draw();
            // });
        });
    </script>

@endsection




