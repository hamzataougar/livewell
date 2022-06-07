class PaginationAjax {
  static init(btn_selector, content_list_sselector) {
    var btn = $(btn_selector);
    var content_container = $(content_list_sselector);
    btn.click(function () {
      var data_query = [];
      var _self = $(this);
      data_query = _self.data();
      data_query.pagination_posts_ajax_nonce = $(
        "#pagination_posts_ajax_nonce"
      ).val();
      _self.find(".loader").show();
      get_data(data_query, function (res) {
        var data = JSON.parse(res);
        _self.find(".loader").hide();
        if (data.data_attr != "") {
          btn_update(data.data_attr);
        }
        if (data.content != "" && data.data_attr.post_count > 0) {
          insert_content(data.content);
          /**lazy loading */
          if (typeof LazyLoad != "undefined") {
            var rw_lazyload = new LazyLoad({
              elements_selector: ".lazy-load",
              class_loaded: "lazy-loaded",
            });
          }
        } else {
          _self.hide();
        }
      });
    });
    
    function btn_update(data_attr) {
      btn.data(data_attr);
    }
    function insert_content(content) {
      content_container.append(content);
    }
    function get_data(params, callback) {
      var response = "";
      var ajax_url = "/";
      params.action = "pagination_posts_ajax";
      $.ajax({
        type: "post",
        url: ajax_url,
        data: params,
        success: callback,
      });
    }
  }
}
jQuery(document).ready(function ($) {
  PaginationAjax.init(".pagination-btn", ".list-posts-hp");
});
