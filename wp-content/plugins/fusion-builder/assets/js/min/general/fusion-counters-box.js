!function(s){"use strict";s.fn.$fusionBoxCounting=function(){var n=s(this).data("value"),o=s(this).data("direction"),e=s(this).data("delimiter"),i=0,t=n,u=fusionCountersBox.counter_box_speed,r=Math.round(fusionCountersBox.counter_box_speed/100);e=e||"","down"===o&&(i=n,t=0),s(this).countTo({from:i,to:t,refreshInterval:r,speed:u,formatter:function(n,o){return"-0"===(n=(n=n.toFixed(o.decimals)).replace(/\B(?=(\d{3})+(?!\d))/g,e))&&(n=0),n}})}}(jQuery),jQuery(window).on("load fusion-element-render-fusion-counters_box",function(n,o){(void 0!==o?jQuery('div[data-cid="'+o+'"]').find(".fusion-counter-box").not(".fusion-modal .fusion-counter-box"):jQuery(".fusion-counter-box").not(".fusion-modal .fusion-counter-box")).each(function(){var n=getWaypointOffset(jQuery(this));jQuery(this).waypoint(function(){jQuery(this).find(".display-counter").each(function(){jQuery(this).$fusionBoxCounting()})},{triggerOnce:!0,offset:n})}),jQuery(".fusion-modal .fusion-counter-box").on("appear",function(){jQuery(this).find(".display-counter").each(function(){jQuery(this).$fusionBoxCounting()})})}),jQuery(window).on("fusion-element-render-fusion_counter_box",function(n,o){jQuery('div[data-cid="'+o+'"]').find(".display-counter").each(function(){jQuery(this).$fusionBoxCounting()})});