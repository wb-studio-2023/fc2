$(function () {
  //材料の追加
  $('.material_add span').on('click', function () {
    var materialBox = $(this).parent().parent().find('.material_box');
    var htmlFactor = "\n            <div class=\"material\">\n                \u540D\u524D\uFF1A<input type=\"text\" name=\"material_name[]\" value=\"\" class=\"material_name\">\n                \u5206\u91CF\uFF1A<input type=\"number\" name=\"material_quantity[]\" value=\"\" class=\"material_quantity\">\n                \u5358\u4F4D\uFF1A<input type=\"text\" name=\"material_unit[]\" value=\"\" class=\"material_unit\">\n                <span class=\"material_delete\">\u2715</span>\n            </div>\n        ";
    $(htmlFactor).appendTo(materialBox);
  });

  //材料の削除
  $('.material_box').on('click', '.material_delete', function () {
    var material = $(this).parent();
    $(material).remove();
  });

  //バリデーションで引っかかって戻ってきたときの処理
  var returnFlg = $('input[name=return_flg]').val();
  var retMaterialCount = $("input[name='ret_matelial_name[]']").length;
  var retMaterialName = $("input[name='ret_matelial_name[]']");
  var retMaterialQuantity = $("input[name='ret_matelial_quantity[]']");
  var retMaterialUnit = $("input[name='ret_material_unit[]']");
  if (returnFlg == 'on' && retMaterialCount > 0) {
    //初期状態で設置されているinpt等を削除
    var materialBox = $('.material_box');
    var material = $(materialBox).find('.material');
    $(material).remove();
    $(retMaterialName).each(function (index, element) {
      var htmlFactor = "\n                <div class=\"material\">\n                    \u540D\u524D\uFF1A<input type=\"text\" name=\"material_name[]\" value=\"" + $(element).val() + "\" class=\"material_name\">\n                    \u5206\u91CF\uFF1A<input type=\"number\" name=\"material_quantity[]\" value=\"" + $(retMaterialQuantity[index]).val() + "\" class=\"material_quantity\">\n                    \u5358\u4F4D\uFF1A<input type=\"text\" name=\"material_unit[]\" value=\"" + $(retMaterialUnit[index]).val() + "\" class=\"material_unit\">\n                    <span class=\"material_delete\">\u2715</span>\n                </div>\n            ";
      $(htmlFactor).appendTo(materialBox);
    });
  }
});
