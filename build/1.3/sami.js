
(function(root) {

    var bhIndex = null;
    var rootPath = '';
    var treeHtml = '        <ul>                <li data-name="namespace:" class="opened">                    <div style="padding-left:0px" class="hd">                        <span class="glyphicon glyphicon-play"></span><a href=".html">App</a>                    </div>                    <div class="bd">                                <ul>                <li data-name="namespace:" class="opened">                    <div style="padding-left:18px" class="hd">                        <span class="glyphicon glyphicon-play"></span><a href=".html">Console</a>                    </div>                    <div class="bd">                                <ul>                <li data-name="namespace:App_Console_Commands" >                    <div style="padding-left:36px" class="hd">                        <span class="glyphicon glyphicon-play"></span><a href="App/Console/Commands.html">Commands</a>                    </div>                    <div class="bd">                                <ul>                <li data-name="class:App_Console_Commands_ComposerSecurityCheck" >                    <div style="padding-left:62px" class="hd leaf">                        <a href="App/Console/Commands/ComposerSecurityCheck.html">ComposerSecurityCheck</a>                    </div>                </li>                </ul></div>                </li>                </ul></div>                </li>                </ul></div>                </li>                            <li data-name="namespace:" class="opened">                    <div style="padding-left:0px" class="hd">                        <span class="glyphicon glyphicon-play"></span><a href=".html">Padosoft</a>                    </div>                    <div class="bd">                                <ul>                <li data-name="namespace:Padosoft_ComposerSecurityCheck" class="opened">                    <div style="padding-left:18px" class="hd">                        <span class="glyphicon glyphicon-play"></span><a href="Padosoft/ComposerSecurityCheck.html">ComposerSecurityCheck</a>                    </div>                    <div class="bd">                                <ul>                <li data-name="class:Padosoft_ComposerSecurityCheck_ComposerSecurityCheckServiceProvider" >                    <div style="padding-left:44px" class="hd leaf">                        <a href="Padosoft/ComposerSecurityCheck/ComposerSecurityCheckServiceProvider.html">ComposerSecurityCheckServiceProvider</a>                    </div>                </li>                </ul></div>                </li>                </ul></div>                </li>                </ul>';

    var searchTypeClasses = {
        'Namespace': 'label-default',
        'Class': 'label-info',
        'Interface': 'label-primary',
        'Trait': 'label-success',
        'Method': 'label-danger',
        '_': 'label-warning'
    };

    var searchIndex = [
                    
            {"type": "Namespace", "link": "Padosoft.html", "name": "Padosoft", "doc": "Namespace Padosoft"},{"type": "Namespace", "link": "Padosoft/LaravelComposerSecurity.html", "name": "Padosoft\\LaravelComposerSecurity", "doc": "Namespace Padosoft\\LaravelComposerSecurity"},
            
            {"type": "Class", "fromName": "Padosoft\\LaravelComposerSecurity", "fromLink": "Padosoft/LaravelComposerSecurity.html", "link": "Padosoft/LaravelComposerSecurity/ComposerSecurityCheck.html", "name": "Padosoft\\LaravelComposerSecurity\\ComposerSecurityCheck", "doc": "&quot;&quot;"},
                                                        {"type": "Method", "fromName": "Padosoft\\LaravelComposerSecurity\\ComposerSecurityCheck", "fromLink": "Padosoft/LaravelComposerSecurity/ComposerSecurityCheck.html", "link": "Padosoft/LaravelComposerSecurity/ComposerSecurityCheck.html#method___construct", "name": "Padosoft\\LaravelComposerSecurity\\ComposerSecurityCheck::__construct", "doc": "&quot;Create a new command instance.&quot;"},
                    {"type": "Method", "fromName": "Padosoft\\LaravelComposerSecurity\\ComposerSecurityCheck", "fromLink": "Padosoft/LaravelComposerSecurity/ComposerSecurityCheck.html", "link": "Padosoft/LaravelComposerSecurity/ComposerSecurityCheck.html#method_handle", "name": "Padosoft\\LaravelComposerSecurity\\ComposerSecurityCheck::handle", "doc": "&quot;Execute the console command.&quot;"},
            
            {"type": "Class", "fromName": "Padosoft\\LaravelComposerSecurity", "fromLink": "Padosoft/LaravelComposerSecurity.html", "link": "Padosoft/LaravelComposerSecurity/ComposerSecurityCheckServiceProvider.html", "name": "Padosoft\\LaravelComposerSecurity\\ComposerSecurityCheckServiceProvider", "doc": "&quot;&quot;"},
                                                        {"type": "Method", "fromName": "Padosoft\\LaravelComposerSecurity\\ComposerSecurityCheckServiceProvider", "fromLink": "Padosoft/LaravelComposerSecurity/ComposerSecurityCheckServiceProvider.html", "link": "Padosoft/LaravelComposerSecurity/ComposerSecurityCheckServiceProvider.html#method_boot", "name": "Padosoft\\LaravelComposerSecurity\\ComposerSecurityCheckServiceProvider::boot", "doc": "&quot;Bootstrap the application events.&quot;"},
                    {"type": "Method", "fromName": "Padosoft\\LaravelComposerSecurity\\ComposerSecurityCheckServiceProvider", "fromLink": "Padosoft/LaravelComposerSecurity/ComposerSecurityCheckServiceProvider.html", "link": "Padosoft/LaravelComposerSecurity/ComposerSecurityCheckServiceProvider.html#method_register", "name": "Padosoft\\LaravelComposerSecurity\\ComposerSecurityCheckServiceProvider::register", "doc": "&quot;Register the service provider.&quot;"},
                    {"type": "Method", "fromName": "Padosoft\\LaravelComposerSecurity\\ComposerSecurityCheckServiceProvider", "fromLink": "Padosoft/LaravelComposerSecurity/ComposerSecurityCheckServiceProvider.html", "link": "Padosoft/LaravelComposerSecurity/ComposerSecurityCheckServiceProvider.html#method_provides", "name": "Padosoft\\LaravelComposerSecurity\\ComposerSecurityCheckServiceProvider::provides", "doc": "&quot;Get the services provided by the provider.&quot;"},
            
            {"type": "Class", "fromName": "Padosoft\\LaravelComposerSecurity", "fromLink": "Padosoft/LaravelComposerSecurity.html", "link": "Padosoft/LaravelComposerSecurity/FileHelper.html", "name": "Padosoft\\LaravelComposerSecurity\\FileHelper", "doc": "&quot;&quot;"},
                                                        {"type": "Method", "fromName": "Padosoft\\LaravelComposerSecurity\\FileHelper", "fromLink": "Padosoft/LaravelComposerSecurity/FileHelper.html", "link": "Padosoft/LaravelComposerSecurity/FileHelper.html#method_findFiles", "name": "Padosoft\\LaravelComposerSecurity\\FileHelper::findFiles", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Padosoft\\LaravelComposerSecurity\\FileHelper", "fromLink": "Padosoft/LaravelComposerSecurity/FileHelper.html", "link": "Padosoft/LaravelComposerSecurity/FileHelper.html#method_adjustPath", "name": "Padosoft\\LaravelComposerSecurity\\FileHelper::adjustPath", "doc": "&quot;&quot;"},
            
            {"type": "Class", "fromName": "Padosoft\\LaravelComposerSecurity", "fromLink": "Padosoft/LaravelComposerSecurity.html", "link": "Padosoft/LaravelComposerSecurity/MailHelper.html", "name": "Padosoft\\LaravelComposerSecurity\\MailHelper", "doc": "&quot;&quot;"},
                                                        {"type": "Method", "fromName": "Padosoft\\LaravelComposerSecurity\\MailHelper", "fromLink": "Padosoft/LaravelComposerSecurity/MailHelper.html", "link": "Padosoft/LaravelComposerSecurity/MailHelper.html#method_setUp", "name": "Padosoft\\LaravelComposerSecurity\\MailHelper::setUp", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Padosoft\\LaravelComposerSecurity\\MailHelper", "fromLink": "Padosoft/LaravelComposerSecurity/MailHelper.html", "link": "Padosoft/LaravelComposerSecurity/MailHelper.html#method___construct", "name": "Padosoft\\LaravelComposerSecurity\\MailHelper::__construct", "doc": "&quot;MailHelper constructor.&quot;"},
                    {"type": "Method", "fromName": "Padosoft\\LaravelComposerSecurity\\MailHelper", "fromLink": "Padosoft/LaravelComposerSecurity/MailHelper.html", "link": "Padosoft/LaravelComposerSecurity/MailHelper.html#method_sendEmail", "name": "Padosoft\\LaravelComposerSecurity\\MailHelper::sendEmail", "doc": "&quot;&quot;"},
            
            {"type": "Class", "fromName": "Padosoft\\LaravelComposerSecurity", "fromLink": "Padosoft/LaravelComposerSecurity.html", "link": "Padosoft/LaravelComposerSecurity/SensiolabHelper.html", "name": "Padosoft\\LaravelComposerSecurity\\SensiolabHelper", "doc": "&quot;&quot;"},
                                                        {"type": "Method", "fromName": "Padosoft\\LaravelComposerSecurity\\SensiolabHelper", "fromLink": "Padosoft/LaravelComposerSecurity/SensiolabHelper.html", "link": "Padosoft/LaravelComposerSecurity/SensiolabHelper.html#method___construct", "name": "Padosoft\\LaravelComposerSecurity\\SensiolabHelper::__construct", "doc": "&quot;SensiolabHelper constructor.&quot;"},
                    {"type": "Method", "fromName": "Padosoft\\LaravelComposerSecurity\\SensiolabHelper", "fromLink": "Padosoft/LaravelComposerSecurity/SensiolabHelper.html", "link": "Padosoft/LaravelComposerSecurity/SensiolabHelper.html#method_getSensiolabVulnerabilties", "name": "Padosoft\\LaravelComposerSecurity\\SensiolabHelper::getSensiolabVulnerabilties", "doc": "&quot;Send Request to sensiolab and return array of sensiolab vulnerabilities.&quot;"},
                    {"type": "Method", "fromName": "Padosoft\\LaravelComposerSecurity\\SensiolabHelper", "fromLink": "Padosoft/LaravelComposerSecurity/SensiolabHelper.html", "link": "Padosoft/LaravelComposerSecurity/SensiolabHelper.html#method_parseVulnerability", "name": "Padosoft\\LaravelComposerSecurity\\SensiolabHelper::parseVulnerability", "doc": "&quot;&quot;"},
                    {"type": "Method", "fromName": "Padosoft\\LaravelComposerSecurity\\SensiolabHelper", "fromLink": "Padosoft/LaravelComposerSecurity/SensiolabHelper.html", "link": "Padosoft/LaravelComposerSecurity/SensiolabHelper.html#method_checkResponse", "name": "Padosoft\\LaravelComposerSecurity\\SensiolabHelper::checkResponse", "doc": "&quot;&quot;"},
            
            {"type": "Class", "fromName": "Padosoft\\LaravelComposerSecurity", "fromLink": "Padosoft/LaravelComposerSecurity.html", "link": "Padosoft/LaravelComposerSecurity/WhiteList.html", "name": "Padosoft\\LaravelComposerSecurity\\WhiteList", "doc": "&quot;&quot;"},
                                                        {"type": "Method", "fromName": "Padosoft\\LaravelComposerSecurity\\WhiteList", "fromLink": "Padosoft/LaravelComposerSecurity/WhiteList.html", "link": "Padosoft/LaravelComposerSecurity/WhiteList.html#method_adjustWhiteList", "name": "Padosoft\\LaravelComposerSecurity\\WhiteList::adjustWhiteList", "doc": "&quot;&quot;"},
            
            
                                        // Fix trailing commas in the index
        {}
    ];

    /** Tokenizes strings by namespaces and functions */
    function tokenizer(term) {
        if (!term) {
            return [];
        }

        var tokens = [term];
        var meth = term.indexOf('::');

        // Split tokens into methods if "::" is found.
        if (meth > -1) {
            tokens.push(term.substr(meth + 2));
            term = term.substr(0, meth - 2);
        }

        // Split by namespace or fake namespace.
        if (term.indexOf('\\') > -1) {
            tokens = tokens.concat(term.split('\\'));
        } else if (term.indexOf('_') > 0) {
            tokens = tokens.concat(term.split('_'));
        }

        // Merge in splitting the string by case and return
        tokens = tokens.concat(term.match(/(([A-Z]?[^A-Z]*)|([a-z]?[^a-z]*))/g).slice(0,-1));

        return tokens;
    };

    root.Sami = {
        /**
         * Cleans the provided term. If no term is provided, then one is
         * grabbed from the query string "search" parameter.
         */
        cleanSearchTerm: function(term) {
            // Grab from the query string
            if (typeof term === 'undefined') {
                var name = 'search';
                var regex = new RegExp("[\\?&]" + name + "=([^&#]*)");
                var results = regex.exec(location.search);
                if (results === null) {
                    return null;
                }
                term = decodeURIComponent(results[1].replace(/\+/g, " "));
            }

            return term.replace(/<(?:.|\n)*?>/gm, '');
        },

        /** Searches through the index for a given term */
        search: function(term) {
            // Create a new search index if needed
            if (!bhIndex) {
                bhIndex = new Bloodhound({
                    limit: 500,
                    local: searchIndex,
                    datumTokenizer: function (d) {
                        return tokenizer(d.name);
                    },
                    queryTokenizer: Bloodhound.tokenizers.whitespace
                });
                bhIndex.initialize();
            }

            results = [];
            bhIndex.get(term, function(matches) {
                results = matches;
            });

            if (!rootPath) {
                return results;
            }

            // Fix the element links based on the current page depth.
            return $.map(results, function(ele) {
                if (ele.link.indexOf('..') > -1) {
                    return ele;
                }
                ele.link = rootPath + ele.link;
                if (ele.fromLink) {
                    ele.fromLink = rootPath + ele.fromLink;
                }
                return ele;
            });
        },

        /** Get a search class for a specific type */
        getSearchClass: function(type) {
            return searchTypeClasses[type] || searchTypeClasses['_'];
        },

        /** Add the left-nav tree to the site */
        injectApiTree: function(ele) {
            ele.html(treeHtml);
        }
    };

    $(function() {
        // Modify the HTML to work correctly based on the current depth
        rootPath = $('body').attr('data-root-path');
        treeHtml = treeHtml.replace(/href="/g, 'href="' + rootPath);
        Sami.injectApiTree($('#api-tree'));
    });

    return root.Sami;
})(window);

$(function() {

    // Enable the version switcher
    $('#version-switcher').change(function() {
        window.location = $(this).val()
    });

    
        // Toggle left-nav divs on click
        $('#api-tree .hd span').click(function() {
            $(this).parent().parent().toggleClass('opened');
        });

        // Expand the parent namespaces of the current page.
        var expected = $('body').attr('data-name');

        if (expected) {
            // Open the currently selected node and its parents.
            var container = $('#api-tree');
            var node = $('#api-tree li[data-name="' + expected + '"]');
            // Node might not be found when simulating namespaces
            if (node.length > 0) {
                node.addClass('active').addClass('opened');
                node.parents('li').addClass('opened');
                var scrollPos = node.offset().top - container.offset().top + container.scrollTop();
                // Position the item nearer to the top of the screen.
                scrollPos -= 200;
                container.scrollTop(scrollPos);
            }
        }

    
    
        var form = $('#search-form .typeahead');
        form.typeahead({
            hint: true,
            highlight: true,
            minLength: 1
        }, {
            name: 'search',
            displayKey: 'name',
            source: function (q, cb) {
                cb(Sami.search(q));
            }
        });

        // The selection is direct-linked when the user selects a suggestion.
        form.on('typeahead:selected', function(e, suggestion) {
            window.location = suggestion.link;
        });

        // The form is submitted when the user hits enter.
        form.keypress(function (e) {
            if (e.which == 13) {
                $('#search-form').submit();
                return true;
            }
        });

    
});


