$.fn.D3PieChart = function(options, search_type) {

    var defaults = {
        "color": d3.schemeCategory10,
        "height": 320,
        "width": 320,
        "duration": 500,
        "delay": 0,
        "ease": d3.easeLinear
    };
    var settings = $.extend({}, defaults, options);
    var radius = Math.min(settings.width, settings.height) / 2 - 10;

    // SVG領域設定
    var svg = d3.select("#" + $(this).attr("id"))
        .append("svg").
        attr("width", settings.width)
        .attr("height", settings.height);
    var g = svg.append("g").attr("transform", "translate(" + settings.width / 2 + "," + settings.height / 2 + ")");

    // pieチャートカラー設定
    var color = d3.scaleOrdinal(settings.color);

    // pieチャートデータセット
    var pie = d3.pie()
        .value(function(d) { return d.value; })
        .sort(null);

    // pieチャートSVG要素の設定
    var pieGroup = g.selectAll(".pie")
        .data(pie(settings.data))
        .enter()
        .append("g")
        .attr("class", "pie");

    var arc = d3.arc()
        .outerRadius(radius)
        .innerRadius(0);

    // pieチャート描画
    pieGroup.append("path")
        .style("fill", function(d, i) {
            return color(i);
        })
        .transition()
        .duration(settings.duration)
        .delay(function(d, i){
            return settings.delay * i;
        })
        .ease(settings.ease)
        .attr("opacity", 0.75)
        .attr("stroke", "white")
        .attrTween("d", function (d) {
            var interpolate = d3.interpolate(
                {startAngle: d.startAngle, endAngle: d.startAngle},
                {startAngle: d.startAngle, endAngle: d.endAngle}
            );
            return function (t) {
                return arc(interpolate(t));
            }
        });

    // pieチャートテキスト設定
    var text = d3.arc()
        .outerRadius(radius - 30)
        .innerRadius(radius - 30);

    pieGroup.append("text")
        .attr("fill", "black")
        .attr("transform", function(d) { return "translate(" + text.centroid(d) + ")"; })
        .attr("dy", "5px")
        .attr("font", "10px")
        .attr("text-anchor", "middle")
        .text(function(d) { return d.data.name; });

    // ツールチップ
    var tooltip = d3.select("body").append("div").attr("class", "tooltip");
    pieGroup.on("mouseover", function(d) {
            tooltip
                .style("visibility", "visible")
                .html(tooltipText(search_type).name + " : " + d.data.name + "<br>" + tooltipText(search_type).count + " : " + d.value);
        })
            .on("mousemove", function(d) {
                tooltip
                    .style("top", (d3.event.pageY - 20) + "px")
                    .style("left", (d3.event.pageX + 10) + "px");
            })
            .on("mouseout", function(d) {
                tooltip.style("visibility", "hidden");
            });

};

var tooltipText = function (type) {
    switch (type) {
        case '0':
        return { 'name' : '操作名', 'count' : '実行回数' };
        case '1':
            return { 'name' : 'アプリケーション名', 'count' : '実行回数' };
        case '2':
            return { 'name' : '企業名', 'count' : '操作回数' };
        case '3':
            return { 'name' : 'ユーザー名', 'count' : '操作回数' };
        default: // 想定外の値が来た場合のエラー対処
            return { 'name' : 'name', 'count' : 'count' };
    }
};