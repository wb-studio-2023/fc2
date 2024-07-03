$(function() {
    //公開・非公開時間
    // 初期表示
    var returnFlg = $("input[name=return_flg]").val(),
        kindFlg = $("input[name=kind_flg]").val(),
        endActiveFlag = $("input[name=endstatus]").prop("checked");
    
    //公開開始時刻
    if (returnFlg == 'on' || kindFlg == 'edit') {
        var setRYear = $("input[name=set_rel_year]").val();
        var setRMonth = Number($("input[name=set_rel_month]").val());
        var setRDate = Number($("input[name=set_rel_day]").val());
        var setRHours = Number($("input[name=set_rel_hour]").val());
        var setRMinute = Number($("input[name=set_rel_minute]").val());
    } else {
        var current = new Date();
        var setRYear = current.getFullYear();
        var setRMonth = current.getMonth() + 1;
        var setRDate = current.getDate();
        var setRHours = current.getHours();
        var setRMinute = current.getMinutes();
    }

    //公開終了時刻
    if (!endActiveFlag) {
        var current = new Date();
        var setEYear = current.getFullYear();
        var setEMonth = current.getMonth() + 1;
        var setEDate = current.getDate();
        var setEHours = current.getHours();
        var setEMinute = current.getMinutes();
    } else {
        var setEYear = $("input[name=set_end_year]").val();
        var setEMonth = Number($("input[name=set_end_month]").val());
        var setEDate = Number($("input[name=set_end_day]").val());
        var setEHours = Number($("input[name=set_end_hour]").val());
        var setEMinute = Number($("input[name=set_end_minute]").val());
    }

    //公開開始時間SET
    $('select[name=release_year] option[value=' + setRYear + ']').prop('selected', true);
    $('select[name=release_month] option[value=' + setRMonth + ']').prop('selected', true);
    $('select[name=release_hour] option[value=' + setRHours + ']').prop('selected', true);
    $('select[name=release_minute] option[value=' + setRMinute + ']').prop('selected', true);
    setReleaseDay();
    $('select[name=release_day] option[value=' + setRDate + ']').prop('selected', true);
    //公開終了時間SET
    $('select[name=end_year] option[value=' + setEYear + ']').prop('selected', true);
    $('select[name=end_month] option[value=' + setEMonth + ']').prop('selected', true);
    $('select[name=end_hour] option[value=' + setEHours + ']').prop('selected', true);
    $('select[name=end_minute] option[value=' + setEMinute + ']').prop('selected', true);
    setEndDay(endActiveFlag);
    $('select[name=end_day] option[value=' + setEDate + ']').prop('selected', true);

    // 年/月 変更--公開開始
    $('select[name=release_year], select[name=release_month]').change(function() {
        setReleaseDay();
    });
    // 年/月 変更--公開終了
    $('select[name=end_year], select[name=end_month]').change(function() {
        setEndDay(true);
    });
    $("input[name=endstatus]").change(function() {
        if($(this).prop("checked") == true){
            $('select[name=end_year]').prop('disabled', false);
            $('select[name=end_month]').prop('disabled', false);
            $('select[name=end_day]').prop('disabled', false);
            $('select[name=end_hour]').prop('disabled', false);
            $('select[name=end_minute]').prop('disabled', false);
        }else{
            $('select[name=end_year]').prop('disabled', true);
            $('select[name=end_month]').prop('disabled', true);
            $('select[name=end_day]').prop('disabled', true);
            $('select[name=end_hour]').prop('disabled', true);
            $('select[name=end_minute]').prop('disabled', true);
        };
    });

    //プロフィール画像--upload
    $('#eyecatch').change(function(e){
        //ファイルオブジェクトを取得する
        var file = e.target.files[0];
        var reader = new FileReader();
        //画像でない場合は処理終了
        if(file.type.indexOf("image") < 0){
          alert("画像ファイルを指定してください。");
          return false;
        }
     
        //アップロードした画像を設定する
        reader.onload = (function(file){
          return function(e){
            $("#thumb").attr("src", e.target.result);
            $("#thumb").attr("title", file.name);
            $("#thumb").css('display', 'block');
            $('.img_name').text(file.name);
            $('#eyecatch_text').val(file.name);
            $('input[name=change_eyecatch]').val('change');
            window.sessionStorage.setItem(['article_eyecatch'],[file.name]);
            window.sessionStorage.setItem(['change_eyecatch'],[file.name]);
          };
        })(file);
        reader.readAsDataURL(file);
      });
    
    //プロフィール画像--onload
    if ( window.sessionStorage.getItem(['article_eyecatch']) ) {
        var imageSeesionValue = window.sessionStorage.getItem(['article_eyecatch']);
        if ( $('input[name=view_type]').val() == 'form') {
            $('input#eyecatch_text').val(imageSeesionValue);
        }
    }

    if ($('input#eyecatch_text').val() != '') {
        var displayFileName = $('input#eyecatch_text').val();
        if (window.sessionStorage.getItem(['change_eyecatch'])) {
            $("#thumb").attr("src", location.protocol + '//' + location.host + '/storage/eyecatch/' + displayFileName);
            $("#thumb").attr("title", displayFileName);
            $('.img_name').text(displayFileName);
        } else {
            $(".img_name").css('display', 'none');
            $("#thumb").attr("src", displayFileName);
        }
        $("#thumb").css('display', 'block');
    }

    $('#list .query_area .create a, #list .list_area table a, .button_area button[name=action]').on('click', function() {
        window.sessionStorage.removeItem(['article_eyecatch']);
        window.sessionStorage.removeItem(['change_eyecatch']);
    });

    //食材・タグの開閉
    $('.close .opener img').on('click', function() {
        var tdId = $(this).closest('td').attr("id");
        $('#' + tdId + ' .close').css('display', 'none');
        $('#' + tdId + ' .open').css('display', 'block');
    });
      
    $('.open .complete a').on('click', function() {
        var tdId = $(this).closest('td').attr("id");
        setChoicedText(tdId);
        $('#' + tdId + ' .close').css('display', 'flex');
        $('#' + tdId + ' .open').css('display', 'none');
    });      

    $('td.open_block').each(function() {
        var tdId = $(this).attr("id");
        setChoicedText(tdId);
    });

});


/**
 * 日プルダウンの制御
 */
function setReleaseDay()
{
    yearVal = $('select[name=release_year]').val();
    monthVal = $('select[name=release_month]').val();

    // 指定月の末日
    var t = 31;
    // 2月
    if (monthVal == 2) {
        //　4で割りきれる且つ100で割りきれない年、または400で割り切れる年は閏年
        if (Math.floor(yearVal%4) == 0 && Math.floor(yearVal%100) != 0 || Math.floor(yearVal%400) == 0) {
        t = 29;
        }  else {
        t = 28;
        }
        // 4,6,9,11月
    } else if (monthVal == 4 || monthVal == 6 || monthVal == 9 || monthVal == 11) {
        t = 30;
    }

    // 初期化
    $('select[name=release_day] option').remove();
    for (var i = 1; i <= t; i++){
        $('select[name=release_day]').append('<option value="' + i + '">' + i + '</option>');
    }
}

/**
 * 日プルダウンの制御
 */
function setEndDay(endActiveFlag)
{
    yearVal = $('select[name=end_year]').val();
    monthVal = $('select[name=end_month]').val();

    // 指定月の末日
    var t = 31;
    // 2月
    if (monthVal == 2) {
        //　4で割りきれる且つ100で割りきれない年、または400で割り切れる年は閏年
        if (Math.floor(yearVal%4) == 0 && Math.floor(yearVal%100) != 0 || Math.floor(yearVal%400) == 0) {
        t = 29;
        }  else {
        t = 28;
        }
        // 4,6,9,11月
    } else if (monthVal == 4 || monthVal == 6 || monthVal == 9 || monthVal == 11) {
        t = 30;
    }

    // 初期化
    $('select[name=end_day] option').remove();
    for (var i = 1; i <= t; i++){
        $('select[name=end_day]').append('<option value="' + i + '">' + i + '</option>');
    }

    if (!endActiveFlag) {
        $('select[name=end_year]').prop('disabled', true);
        $('select[name=end_month]').prop('disabled', true);
        $('select[name=end_day]').prop('disabled', true);
        $('select[name=end_hour]').prop('disabled', true);
        $('select[name=end_minute]').prop('disabled', true);
    }
}


/**
 * pタグにtextを与える
 */
function setChoicedText(tdId)
{
    var pTextArray = [];
    $('#' + tdId + ' input[type="checkbox"]:checked').each(function() {
        var checkboxText = $(this).parent().text().trim();
        pTextArray.push(checkboxText);
    });
    var pText = pTextArray.join('、');
    $('#' + tdId + ' .close p').text(pText);
}

