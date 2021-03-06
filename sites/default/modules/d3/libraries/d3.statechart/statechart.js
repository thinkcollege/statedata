/**
 * @file
 * Adds a function to generate a column chart to the `Drupal` object.
 */

(function($) {

  Drupal.d3.statechart = function (select, settings) {
    var curvalue = window.location.href.substring(window.location.href.lastIndexOf('/') + 1).replace(/%20/g,"-");
      var curvalue2 = window.location.href.substring(window.location.href.lastIndexOf('/') + 1).replace(/%20/g," ");

    var rows = settings.rows,
      // Use first value in each row as the label.
      xLabels = rows.map(function(d) { return d.shift(); })
      key = settings.legend,
      // Hack PF override the number of legend values to add extra legend elements
      adjkeylen = 1,
      // From inside out:
      // - Convert all values to numeric numbers.
      // - Merge all sub-arrays into one flat array.
      // - Return the highest (numeric) value from flat array.
      max = d3.max(d3.merge(settings.rows).map(function(d) { return + d; })),
      // Padding is top, right, bottom, left as in css padding.
      p = [80, 50, 0, 50],
      w = 1100,
      h = 300,
      // chart is 65% and 80% of overall height
      chart = {w: w * .75, h: h * .35},
      legend = {w: w * .75, h:h},
      // bar width is calculated based on chart width, and amount of data
      // items - will resize if there is more or less
      barWidth = ((.90 * chart.w) / (rows.length * adjkeylen)),
      // each cluster of bars - makes coding later easier
      barGroupWidth = (adjkeylen * barWidth),
      // space in between each set
      barSpacing = (.10 * chart.w) / rows.length,
      x = d3.scale.linear().domain([0,rows.length]).range([0,chart.w]),
      y = d3.scale.linear().domain([0,max]).range([chart.h, 0]),
      z = d3.scale.ordinal().range(["#cf5050", "#ffff99", "orange", "green", "#B0C2A5"]),
      zz = d3.scale.ordinal().range(["#cf5050","orange", "green", "#B0C2A5"]),
      
      div = (settings.id) ? settings.id : 'visualization';
      
    var svg = d3.select('#' + div).append("svg")
      .attr("width", w)
      .attr("height", h)
      .append("g")
      .attr("transform", "translate(" + p[3] + "," + p[0] + ")");

    var graph = svg.append("g")
      .attr("class", "chart");

    /* X AXIS  */
    var xTicks = graph.selectAll("g.ticks")
      .data(rows)
      .enter().append("g")
      .attr("class","ticks")
      .attr('transform', function(d,i) { return 'translate(' + (x(i) + (barGroupWidth / 2)) + ',' + (chart.h) + ')'})
      .append("text")
      .attr("dy", ".71em")
      .attr("text-anchor", "end")
      .attr('transform', function(d,i) { return "rotate(-45)"; })
      .text(function(d,i){ return xLabels[i]; });

    /* LINES */
    var rule = graph.selectAll("g.rule")
      .data(y.ticks(4))
      .enter().append("g")
      .attr("class", "rule")
      .attr("transform", function(d) { return "translate(0," + y(d) + ")"; });

    rule.append("line")
      .attr("x2", chart.w)
      .style("stroke", function(d) { return d ? "#ccc" : "#000"; })
      .style("stroke-opacity", function(d) { return d ? .7 : null; });

    /* Y AXIS */
    rule.append("text")
      .attr("x", 0)
      .attr("dy", ".75em")
      .attr("text-anchor", "end")
      .text(d3.format(",d"));


    var bar = graph.selectAll('g.bars')
      .data(rows)
      .enter().append('g')
      .attr('class', 'bargroup')
.attr('id', function(d,i){ 
  
return xLabels[i].split(" ").join("-");
    })
      .attr('transform', function(d,i) { return "translate(" + i * (barGroupWidth + barSpacing) + ", 0)"; });

    bar.selectAll('rect')
      .data(function(d) { return d; })

      .enter().append('rect')
      .attr("width", barWidth)
      .attr("height", function(d) { return chart.h - y(d); })
      .attr('x', function (d,i) { return i * barWidth; })
      .attr('y', function (d,i) { return y(d); })
      .attr('fill', function(d,i) { return d3.rgb(z(i)); })
      .on('mouseover', function(d,i) { var currentstate = $(this).parent().attr('id').replace("-"," "); showToolTip(currentstate,d, i, this); })
    .on('mouseout', function(d, i) { hideToolTip(d, i, this); });
$('rect').each( function() {if ($(this).parent().attr('id') == curvalue) {$(this).attr('fill', '#ffff99');}})
$('rect').each( function() {if ($(this).parent().attr('id') == "Nation") {$(this).attr('fill', 'orange');}})
$('g.ticks text').each( function() {if ($(this).text() == curvalue2) {$(this).css('font-weight', 'bold');}})
    /* LEGEND */
    var legend = svg.append("g")
      .attr("class", "legend")
      .attr("transform", "translate(" + (0) + "," + -60 + ")");

    var keys = legend.selectAll("g")
      .data(key)
      .enter().append("g")
      .attr("transform", function(d,i) { return "translate(0," + d3.tileText(d,1100) + ")"});

    keys.append("rect")
      .attr("fill", function(d,i) { return (keys.size() < 3 ? d3.rgb(zz(i)) :d3.rgb(z(i))); })
      .attr("width", 16)
      .attr("height", 16)
      .attr("y", 0)
      .attr("x", 0);

    var labelWrapper = keys.append("g");

    labelWrapper.selectAll("text")
      .data(function(d,i) { return d3.splitString(key[i], 1100); })
      .enter().append("text")
      .text(function(d,i) { return d})
      .attr("x", 20)
      .attr("y", function(d,i) { return i * 20})
      .attr("dy", "1em");

    function showToolTip(currentstate,d, i, obj ) {
      // Change color and style of the bar.
      var bar = d3.select(obj);
      bar.attr('stroke', '#ccc')
        .attr('stroke-width', '1')
        .attr('opacity', '0.75');
        var w = (currentstate.length + 6) * 6.7;
      var group = d3.select(obj.parentNode);

      var tooltip = graph.append('g')
        .attr('class', 'tooltip')
        // move to the x position of the parent group
        .attr('transform', function(data) { return group.attr('transform'); })
          .append('g')
        // now move to the actual x and y of the bar within that group
        .attr('transform', function(data) { return 'translate(' + (Number(bar.attr('x')) + barWidth) + ',' + y(d) + ')'; });
  
        

      d3.statetooltip(currentstate,tooltip,d,40,w,'chart');
    }

    function hideToolTip(d, i, obj) {
      var group = d3.select(obj.parentNode);
      var bar = d3.select(obj);
      bar.attr('stroke-width', '0')
        .attr('opacity', 1);

      graph.select('g.tooltip').remove();
    }
  }
})(jQuery);
