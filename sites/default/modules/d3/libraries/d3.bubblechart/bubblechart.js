/**
 * @file
 * Adds a function to generate a column chart to the `Drupal` object.
 */

/**
 * Notes on data formatting:
 * legend: array of text values. Length is number of data types.
 * rows: array of arrays. One array for each point of data
 * arrays have format array(label, data1, data2, data3, ...)
 */

(function($) {

  Drupal.d3.bubblechart = function (select, settings) {

    //Setting JSON data.
    var jsonData = settings.rows,
    //Setting chart title.
    chartTitle = settings.title,
    // Setting background color.
    bgColor = settings.colour,
    //Setting dimension of the draw area occupied by chart in pixels.
    diameter = settings.width,
    format = d3.format(",d"),
    color = d3.scale.ordinal().range(settings.series_colours);

    var bubble = d3.layout.pack()
        .sort(null)
        .size([diameter, diameter])
        .padding(1.5);

    var svg = d3.select("#"+settings.id).append("svg")
        .attr("width", diameter)
        .attr("height", diameter)
        .attr("class", "bubble")
        .style('background', bgColor);

    root = JSON.parse( jsonData ); 
      var node = svg.selectAll(".node")
      .data(bubble.nodes(classes(root))
          .filter(function(d) { return !d.children; }))
          .enter().append("g")
          .attr("class", "node")
          .attr("id", function(d, i) { return "node-"+i; })
          .attr("transform", function(d) { return "translate(" + d.x + "," + d.y + ")"; });

//      node.append("title")
//          .text(function(d) { return d.className + ": " + format(d.value); });

      node.append("circle")
          .attr("r", function(d) { return d.r; })
          .style("fill", function(d, i) { return color(i); })
          .attr('stroke', function(d, i) { return color(i); })
          .attr('stroke-width', '1')
          .attr('opacity', '1')
          .on('mouseover', function(d, i) { interact('over', i); })
          .on('mouseout', function(d, i) { interact('out', i); })
          .attr('class', function(d, i) { return 'color_' + (color(i)).replace("#","") + ' bubble-' + i; });

      node.append("text")
          .attr("dy", ".3em")
          .attr("font-size","10px")
          .style("text-anchor", "middle")
          .style("font-family", "sans-serif")
          .text(function(d) { return d.className.substring(0, d.r / 3); });

    // Returns a flattened hierarchy containing all leaf nodes under the root.
    function classes(root) {
      var classes = [];

      function recurse(name, node) {
        if (node.children) node.children.forEach(function(child) { recurse(node.name, child); });
        else classes.push({packageName: name, className: node.name, value: node.size});
      }

      recurse(null, root);
      return {children: classes};
    }

    /**
     * Wrapper function for all rollover functions.
     *
     * @param string text
     *   Current state, 'over', or 'out'.
     * @param int i
     *   Current index of the current data row.
     * @return none
     */
    function interact(state, i) {
      if (state == 'over') {
        highlightBubble(i);
        showTooltip(i);
      }
      else {
        unhighlightBubble(i);
        hideTooltip(i);
      }
      return true;
    }

    //mouse over and out effects
    function highlightBubble(i) {
        d3.selectAll(".bubble-" + i)
        .attr('stroke', '#ccc')
        .attr('stroke-width', '1')
        .attr('opacity', '0.75');
      }

    function unhighlightBubble(i) {
        d3.selectAll(".bubble-" + i)
        .attr('stroke', color(i))
        .attr('stroke-width', '1')
        .attr('opacity', '1');
      }

    function showTooltip(i) {
        var tip = d3.selectAll("#node-"+i).append("g")
        .attr("id", function(d, i) { return "tooltip-"+i; })
        .attr("class", "tooltip")
        .style("z-index", 10000)
        .attr("transform", "translate("+-50+","+-50+")");

        tip.append("rect")
        .attr("class", "tooltip")
        .attr("width", "115")
        .attr("height", 40)
        .attr("fill", "white")
        .style("stroke", "#cccccc");

        var tiptext = tip.append("g")
        .attr("class", "tooltip")
        .attr("font-size","10px")
        .style("font-family", "sans-serif");

        tiptext.append("text")
        .attr("id", "title-"+i)
        .attr("dx", "0.5em")
        .attr("dy", "1.5em")
        .text(function(d) { return d.className; });

        tiptext.append("text")
        .attr("id", "value-"+i)
        .attr("dx", "0.5em")
        .attr("dy", "3em")
        .text(function(d) { return "Value: " + format(d.value); });

    }

    function hideTooltip(i) {
        d3.selectAll("#node-"+i).select("g.tooltip").remove();
    }

    d3.select(self.frameElement).style("height", diameter + "px");
  };

})(jQuery);
