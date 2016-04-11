(function ($) {
    var ajaxFetchTreeNodeUrl = 'ajax.php?command=ajaxFetchTreeNode',
        showPreloadedTreeUrl = 'ajax.php?command=showPreloadedTree';

    var drawSubcategories = function ($parent, data) {
        var $list = $parent.append('<ul></ul>').children('ul'), $listItem = null;

        data.forEach(function (item) {

            $list.append('<li class="collapsed ' + ((!!item.subcategories && item.subcategories.length > 0) ? 'hasChildren' : '') + '"><span>' + item.Name + '</span></li>');

            $listItem = $list.children('li').last();
            if (!!item.subcategories && item.subcategories.length > 0) {
                $listItem.on('click', function (e) {
                    e.stopPropagation();
                    var _this = $(this);

                    if (_this.hasClass('collapsed')) {
                        _this.removeClass('collapsed').addClass('expanded').children('ul').slideDown();
                    }
                    else {
                        _this.removeClass('expanded').addClass('collapsed').children('ul').slideUp();
                    }
                })
                drawSubcategories($listItem, item.subcategories);
            }
            else {
                // needed to attach click event to no-child items
                $listItem.on('click', function (e) {
                    e.stopPropagation();

                    // doing something...
                    console.log('leaf item');
                })
            }
        });
    }

    var drawTreeNode = function ($parent, nodeId) {
        var name = $parent.children('span').text(),
            $list = $parent.html('<span>' + name + '</span><ul><li>loading...</li></ul>').children('ul').last(),
            $listItem = null;

        $.get(ajaxFetchTreeNodeUrl + '&nodeId=' + nodeId, function (data) {

            var listItems = '';

            $parent.addClass('loaded');

            data.forEach(function (item) {

                listItems += '<li data-node-id="' + item.node_id + '" class="collapsed ' + ((item.subcategoriesCount > 0) ? 'hasChildren' : '') + '"><span>' + item.Name + '</span></li>';

            });

            $list.html(listItems);

            $list.children('li').on('click', function (e) {

                e.stopPropagation();
                var _this = $(this);

                if(_this.hasClass('hasChildren')){
                    if (_this.hasClass('collapsed')) {
                        if (!_this.hasClass('loaded')) {
                            drawTreeNode(_this, _this.attr('data-node-id'));
                        }
                        _this.removeClass('collapsed').addClass('expanded').children('ul').slideDown();
                    }
                    else {
                        _this.removeClass('expanded').addClass('collapsed').children('ul').slideUp();
                    }
                }
                else {
                    // doing something...
                    console.log('leaf item');
                }
            })

        })
    }

    $.fn.tree = function (options) {

        var settings = $.extend({
            renderMethod: "lazy"  // lazy|full
        }, options);

        var $treeContainer = $(this);
        $treeContainer.addClass('tree');

        switch (settings.renderMethod) {
            case 'full':
                $.get(showPreloadedTreeUrl, function (data) {
                    drawSubcategories($treeContainer, data);
                })
                break;

            case 'lazy':
                drawTreeNode($treeContainer, 0);
                break;
        }


        return this;
    };

}(jQuery));