jQuery.noConflict();
var j = jQuery;
var order = {};

function activatecardbox() {
    j('#paybox').hide();
    j('.cc_cansnow_eacpay').hide();
    $('apitype_card').checked = true;

    if ($('card_box_sec')) {
        $('card_box_sec').style.display = '';
    }
    j('#cardbox').show();
}

function activatealipaybox() {
    j('#cardbox').hide();
    j('.cc_cansnow_eacpay').hide();
    $('apitype_alipay').checked = true;

    if ($('card_box_sec')) {
        $('card_box_sec').style.display = '';
    }
    j('#paybox').show();
}

function activateeacpay() {
    j('#paybox').hide();
    j('#cardbox').hide();

    $('apitype_eacpay').checked = true;
    if ($('card_box_sec')) { $('card_box_sec').style.display = 'none'; }

    j('.cc_cansnow_eacpay').show();
}

function check() {
    j.get('plugin.php?id=cc_cansnow_eacpay:recharge&action=check&orderid=' + order.orderid, function(d) {
        if (d == "ok") {
            showDialog("Success", 'alert_right');
            setTimeout(function() {
                location.reload();
            }, 2000);
        } else {
            timeId = setTimeout(check, 3000);
        }
    });
}
j(function() {
    j('[for=apitype_alipay]').attr('onclick', "activatealipaybox();");
    j('.long-logo.mbw ul li').addClass('z');
    j('.long-logo.mbw ul').addClass('flex_row').append('<li class="z">' +
        '<input name="bank_type" type="radio" value="eacpay" id="apitype_eacpay" class="vm" onclick="activateeacpay();">' +
        '<label class="vm" style="padding-left:10px;width:165px;height:32px;line-height:32px;background:#FFF;border:1px solid #DDD;display:inline-block;" ' +
        'onclick="activateeacpay();">' +
        '<img src="source/plugin/cc_cansnow_eacpay/logo.png" alt="EACPAY区块链支付" height="100%" style="margin-right:10px;"/>' +
        '<span class="xs2">EACPAY payment</span></label>' +
        '</li>');
    var htm = '<tr class="cc_cansnow_eacpay"><th>EAC price</th><td colspan="2"><div id="exchangeData">' + exchangeData + '</div></tr>';
    htm += '<tr class="cc_cansnow_eacpay">' +
        '<th>Recharge</th><td colspan="2">' +
        '  <input type="text" class="px" style="width:50px;" id="amount" name="amount">    ' + moneytype_title + '    need EAC<span id="needEac"></span>' +
        '<div id="qrcode" style="margin-right: 320px;margin-top: -40px;float: right;">' +
        '   <div style="width:150px;">' +
        '   <img src="source/plugin/cc_cansnow_eacpay/app.png" width="130" />' +
        '   <div>EACPAY wallet Scan pay</div>' +
        '</div>' +
        '</div>' +
        '</td></tr>';

    j('#cardbox').after(htm);
    j('#addfundsform').after(['<div class="cc_cansnow_eacpay"><div class="flex_row eacpay_remark">',
        '<div class="flex_1">' +
        '   <p>RMB cash 1 yuan = ' + moneybl + ' ' + moneytype_title + '</p>',
        '   <p>EACPAY wallet download:</p>',
        '   <p>1、google play</p>',
        '   <p>2、https://eacpay.com</p>',
        '   <p>3、Mobile browser scan download EACPAY</p>',
        '</div>',
        '<div style="width:150px;">',
        '   <img src="source/plugin/cc_cansnow_eacpay/app.png" width="130" />',
        '</div>',
        '</div>'
    ].join(''));
    String.prototype.toInt = function() {
        var s = parseInt(this);
        return isNaN(s) ? 0 : s;
    }

    function exchangecalcredit() {
        j('#amount').val(j('#amount').val().toInt());
        if (j('#amount').val() != 0) {
            j('#amount').val(Math.floor(moneybl * j('#amount').val()));
            j.getJSON('plugin.php?id=cc_cansnow_eacpay:recharge&action=geteac&amount=' + j('#amount').val(), function(d) {
                j('#exchangeData').text(d.exchange + "￥");
                j('#eacamount').text(d.eacamount);
                j('#remark').val(d.orderid);
                j('.eacdetaildata').css('display', 'flex');
                j('#addfundssubmit_btn').show();
            });
        } else {
            j('#amount').val('0');
        }
    }
    j('#amount').on('change', exchangecalcredit);
    j('#addfundssubmit_btn').on('click', function() {
        if ($('apitype_eacpay').checked) {
            j.getJSON('plugin.php?id=cc_cansnow_eacpay:recharge&action=geteac&submit=1&amount=' + j('#exchangeamount').val(), function(d) {
                order = d;
                j('#exchangeData').text(d.exchange + "￥");
                j('#eacamount').text(d.eacamount);
                j('#remark').val(d.orderid);
                j('.eacdetaildata').css('display', 'flex');
                j('#addfundssubmit_btn').hide();
                j('#qrcode').html('<div><img src="' + d.qrcode + '" width="150"/><div>EACPAY wallet Scan pay</div></div>');
                timeId = setTimeout(check, 3000); //Start task
            });
            return false;
        }
    });

});