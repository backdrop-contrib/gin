var $;

$ = jQuery, Backdrop.behaviors.responsivePrimaryTabs = {
  attach: function(context, settings) {
    var $primaryTabs = $(context).find("ul.tabs--primary").once("responsive-tabs");
    if (0 !== $primaryTabs.length) {
      var previousWindowWidth, expandControlWidth, allTabsWidth, activeTabAndBeforeWidth, activeTabAndAfterWidth, $tabsWrapper = $primaryTabs.parent(), $tabs = $("li", $primaryTabs), responsiveTabs = !1, tabWidths = [], widestTabWidth = 0, activeTabNth = $("li.active", $primaryTabs).index(), expandedTabsHeaderPadding = 0, $mobileHeaderPadder = $('<div class="responsive-tabs-mobile-header-padder" style="height: ' + expandedTabsHeaderPadding + 'px"></div>'), $body = $("body"), tabsWrapperPadding = {
        top: parseInt($tabsWrapper.css("padding-top").replace("px", "")),
        right: parseInt($tabsWrapper.css("padding-right").replace("px", "")),
        left: parseInt($tabsWrapper.css("padding-left").replace("px", ""))
      };
      $tabsWrapper.once("responsive-tabs", (function() {
        $primaryTabs.after('<div class="expand-dropdown-tabs-control" tabindex="0" aria-hidden="true"><span class="expand-dropdown-tabs-label"></span></div>'), 
        $(".expand-dropdown-tabs-control", $tabsWrapper).on("keypress click", (function(e) {
          "click" !== e.type && 13 !== e.which || ($tabsWrapper.toggleClass("expand-dropdown-tabs"), 
          $(this).toggleClass("js-active"), expandedTabsHeaderPadding > 0 && $tabsWrapper.hasClass("expand-dropdown-tabs") ? ($mobileHeaderPadder.css("height", expandedTabsHeaderPadding + "px"), 
          $body.prepend($mobileHeaderPadder), $body.scrollTop($body.scrollTop() + expandedTabsHeaderPadding)) : ($mobileHeaderPadder.remove(), 
          $body.scrollTop($body.scrollTop() - expandedTabsHeaderPadding)));
        })), expandControlWidth = $(".expand-dropdown-tabs-control", $tabsWrapper).outerWidth(), 
        $tabs.find("a").wrapInner('<span class="responsive-tabs-link-text-wrapper"></span>'), 
        calculateTabWidths(), adjustTabsDisplay();
      })), $("html").on("click", (function(e) {
        var $target = $(e.target);
        responsiveTabs && !$target.is(".responsive-tabs-processed") && $target.parents(".responsive-tabs-processed").length < 1 && closeTabsDropdown();
      })), Backdrop.isFontLoaded("Ginter", (function() {
        adjustTabsDisplay(), calculateTabWidths();
      })), Backdrop.optimizedResize.add(handleResize), $(document).ready(handleResize);
    }
    function calculateTabWidths() {
      tabWidths = [], allTabsWidth = expandControlWidth, activeTabAndBeforeWidth = expandControlWidth, 
      activeTabAndAfterWidth = expandControlWidth, $tabs.each((function(i) {
        var currentTabWidth = $(".responsive-tabs-link-text-wrapper", this).outerWidth() + 42;
        tabWidths.push(currentTabWidth), allTabsWidth += currentTabWidth, i <= activeTabNth && (activeTabAndBeforeWidth += currentTabWidth), 
        i >= activeTabNth && (activeTabAndAfterWidth += currentTabWidth), currentTabWidth > widestTabWidth && (widestTabWidth = currentTabWidth);
      })), 0 === activeTabNth ? activeTabAndBeforeWidth += tabWidths[1] : activeTabNth === $tabs.length - 1 && (activeTabAndAfterWidth += tabWidths[$tabs.length - 2]);
    }
    function closeTabsDropdown() {
      $tabsWrapper.removeClass("expand-dropdown-tabs"), $tabsWrapper.find(".expand-dropdown-tabs-control").removeClass("js-active"), 
      $mobileHeaderPadder.remove();
    }
    function handleResize() {
      var currentWindowWidth = $(window).width();
      currentWindowWidth !== previousWindowWidth && (previousWindowWidth = currentWindowWidth, 
      closeTabsDropdown(), adjustTabsDisplay());
    }
    function adjustTabsDisplay() {
      var responsiveTabsType;
      if (tabWidths.length > 0) {
        var tabArea = $primaryTabs.outerWidth(), accumulatedTabWidth = expandControlWidth;
        if (tabArea >= allTabsWidth) responsiveTabs = !1, $tabsWrapper.addClass("desktop-primary-tabs"), 
        $tabsWrapper.removeClass("responsive-tabs-before responsive-tabs-after responsive-tabs-mobile"), 
        $primaryTabs.find(".duplicated-tab").removeClass("duplicated-tab"), $tabsWrapper.find(".responsive-tabs-dropdown").remove(), 
        $primaryTabs.css({
          "padding-left": "",
          top: ""
        }); else {
          responsiveTabs = !0;
          var $responsiveTabsDropdown = $('<ul class="primary responsive-tabs-dropdown" aria-hidden="true" style="top: ' + (void 0 + tabsWrapperPadding.top) + "px; width: " + (widestTabWidth + expandControlWidth + 20) + 'px"></ul>');
          if (tabArea >= activeTabAndBeforeWidth) {
            responsiveTabsType = "andBefore";
            var $lastVisibleTab = null;
            $tabs.each((function(i) {
              accumulatedTabWidth += tabWidths[i], "andBefore" === responsiveTabsType && (i <= activeTabNth || accumulatedTabWidth <= tabArea ? ($(this).removeClass("duplicated-tab"), 
              $lastVisibleTab = $(this)) : ($responsiveTabsDropdown.append($(this).clone()), $(this).addClass("duplicated-tab")));
            })), $tabsWrapper.addClass("responsive-tabs-before").removeClass("desktop-primary-tabs responsive-tabs-after responsive-tabs-mobile");
            var expandControlLeft = $lastVisibleTab.position().left + $lastVisibleTab.outerWidth() + tabsWrapperPadding.left;
            $(".expand-dropdown-tabs-control", $tabsWrapper).css("left", expandControlLeft), 
            $responsiveTabsDropdown.css("right", tabArea - expandControlLeft - expandControlWidth + tabsWrapperPadding.right + tabsWrapperPadding.left), 
            $primaryTabs.css("padding-left", 0), expandedTabsHeaderPadding = 0;
          } else if (tabArea >= activeTabAndAfterWidth) responsiveTabsType = "andAfter", accumulatedTabWidth = expandControlWidth, 
          $($tabs.get().reverse()).each((function(reverseI) {
            var i = $tabs.length - 1 - reverseI;
            accumulatedTabWidth += tabWidths[i], i >= activeTabNth || accumulatedTabWidth <= tabArea ? $(this).removeClass("duplicated-tab") : ($responsiveTabsDropdown.prepend($(this).clone()), 
            $(this).addClass("duplicated-tab"));
          })), $(".expand-dropdown-tabs-control", $tabsWrapper).css("left", tabsWrapperPadding.left), 
          $primaryTabs.css("padding-left", expandControlWidth), $tabsWrapper.addClass("responsive-tabs-after").removeClass("desktop-primary-tabs responsive-tabs-before responsive-tabs-mobile"), 
          expandedTabsHeaderPadding = 0; else {
            responsiveTabsType = "mobile", $primaryTabs.find(".duplicated-tab").removeClass("duplicated-tab"), 
            $tabsWrapper.addClass("responsive-tabs-mobile").removeClass("responsive-tabs-before responsive-tabs-after desktop-primary-tabs");
            var tabsOffset = NaN * activeTabNth, tabsTopDistance = $tabsWrapper.position().top;
            $primaryTabs.css("top", "-" + tabsOffset + "px"), tabsOffset > tabsTopDistance && (expandedTabsHeaderPadding = tabsOffset - tabsTopDistance + "20px");
            var $activeTabText = $('<span class="expand-dropdown-tabs-label">' + $primaryTabs.find("li.active a").html() + "</span>");
            $activeTabText.find(".element-invisible").remove(), $tabsWrapper.find(".expand-dropdown-tabs-label").replaceWith($activeTabText), 
            $tabsWrapper.find(".expand-dropdown-tabs-control").css("left", "auto"), $tabsWrapper.find(".responsive-tabs-dropdown").remove(), 
            $primaryTabs.css("padding-left", 0);
          }
          $responsiveTabsDropdown.find("li").length > 0 && ($responsiveTabsDropdown.find(".duplicated-tab").removeClass("duplicated-tab"), 
          $tabsWrapper.find(".responsive-tabs-dropdown").length > 0 ? $tabsWrapper.find(".responsive-tabs-dropdown").replaceWith($responsiveTabsDropdown) : $primaryTabs.after($responsiveTabsDropdown));
        }
      }
    }
  }
};