// HW-Setup

$("#executehw").click(function() {
    var hwid = $("#hwid").attr('value');
    var hwname = $("#hwname").attr('value');
    var hwstatus = encodeURIComponent($("#hwstatus").attr('value'));
    $.post('executesql.php', { mode: "hw-setup", hwid: hwid, hwname: hwname, hwstatus: hwstatus },
        function(data) {
            //alert(data);
            window.parent.location.href = "hw.setup.index.php?id=" + Math.random(100 * 1000, 1000 / 2);
        });
    return false;
});

$("#executebrand").click(function() {
    var brandid = $("#brandid").attr('value');
    var hwid = $("#hwid").attr('value');
    var brandname = $("#brandname").attr('value');
    var brandstatus = encodeURIComponent($("#brandstatus").attr('value'));
    $.post('executesql.php', { mode: "brand-setup", brandid: brandid, hwid: hwid, brandname: brandname, brandstatus: brandstatus },
        function(data) {
            window.parent.location.href = "brand.setup.index.php?id=" + Math.random(100 * 1000, 1000 / 2) + "&math=" + hwid;
        });
    return false;
});

$("#executemodel").click(function() {
    var brandid = $("#brandid").attr('value');
    var modelid = $("#modelid").attr('value');
    var modelname = $("#modelname").attr('value');
    var modelstatus = encodeURIComponent($("#modelstatus").attr('value'));
    $.post('executesql.php', { mode: "model-setup", modelid: modelid, brandid: brandid, modelname: modelname, modelstatus: modelstatus },
        function(data) {
            window.parent.location.href = "model.setup.index.php?id=" + Math.random(100 * 1000, 1000 / 2) + "&math=" + brandid;
        });
    return false;
});

$("#executehwtypexxxxxx").click(function() {
    alert("adsfasdfasds");
    /* var hdid = $("#hdid").attr('value');
     var hwname = $("#hwname").attr('value');
     alert(hwname);
     var hwstatus = encodeURIComponent($("#hwstatus").attr('value'));
     $.post('executesql.php', { mode: "hw-type", hdid: hdid, hwname: hwname, hwstatus: hwstatus },
         function(data) {
             alert(data);
             window.parent.location.href = "hw.type.index.php?id=" + Math.random(100 * 1000, 1000 / 2) + "&math=" + brandid;
         });
     return false;*/
});