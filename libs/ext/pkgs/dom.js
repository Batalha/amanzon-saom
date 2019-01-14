/*

This file is part of Ext JS 4

Copyright (c) 2011 Sencha Inc

Contact:  http://www.sencha.com/contact

GNU General Public License Usage
This file may be used under the terms of the GNU General Public License version 3.0 as published by the Free Software Foundation and appearing in the file LICENSE included in the packaging of this file.  Please review the following information to ensure the GNU General Public License version 3.0 requirements will be met: http://www.gnu.org/copyleft/gpl.html.

If you are unsure which license is appropriate for your use, please contact the sales department at http://www.sencha.com/contact.

*/
/**
 * @class Ext.core.DomHelper
 * <p>The DomHelper class provides a layer of abstraction from DOM and transparently supports creating
 * elements via DOM or using HTML fragments. It also has the ability to create HTML fragment templates
 * from your DOM building code.</p>
 *
 * <p><b><u>DomHelper element specification object</u></b></p>
 * <p>A specification object is used when creating elements. Attributes of this object
 * are assumed to be element attributes, except for 4 special attributes:
 * <div class="mdetail-params"><ul>
 * <li><b><tt>tag</tt></b> : <div class="sub-desc">The tag name of the element</div></li>
 * <li><b><tt>children</tt></b> : or <tt>cn</tt><div class="sub-desc">An array of the
 * same kind of element definition objects to be created and appended. These can be nested
 * as deep as you want.</div></li>
 * <li><b><tt>cls</tt></b> : <div class="sub-desc">The class attribute of the element.
 * This will end up being either the "class" attribute on a HTML fragment or className
 * for a DOM node, depending on whether DomHelper is using fragments or DOM.</div></li>
 * <li><b><tt>html</tt></b> : <div class="sub-desc">The innerHTML for the element</div></li>
 * </ul></div></p>
 * <p><b>NOTE:</b> For other arbitrary attributes, the value will currently <b>not</b> be automatically
 * HTML-escaped prior to building the element's HTML string. This means that if your attribute value
 * contains special characters that would not normally be allowed in a double-quoted attribute value,
 * you <b>must</b> manually HTML-encode it beforehand (see {@link Ext.String#htmlEncode}) or risk
 * malformed HTML being created. This behavior may change in a future release.</p>
 *
 * <p><b><u>Insertion methods</u></b></p>
 * <p>Commonly used insertion methods:
 * <div class="mdetail-params"><ul>
 * <li><b><tt>{@link #append}</tt></b> : <div class="sub-desc"></div></li>
 * <li><b><tt>{@link #insertBefore}</tt></b> : <div class="sub-desc"></div></li>
 * <li><b><tt>{@link #insertAfter}</tt></b> : <div class="sub-desc"></div></li>
 * <li><b><tt>{@link #overwrite}</tt></b> : <div class="sub-desc"></div></li>
 * <li><b><tt>{@link #createTemplate}</tt></b> : <div class="sub-desc"></div></li>
 * <li><b><tt>{@link #insertHtml}</tt></b> : <div class="sub-desc"></div></li>
 * </ul></div></p>
 *
 * <p><b><u>Example</u></b></p>
 * <p>This is an example, where an unordered list with 3 children items is appended to an existing
 * element with id <tt>'my-div'</tt>:<br>
 <pre><code>
var dh = Ext.core.DomHelper; // create shorthand alias
// specification object
var spec = {
    id: 'my-ul',
    tag: 'ul',
    cls: 'my-list',
    // append children after creating
    children: [     // may also specify 'cn' instead of 'children'
        {tag: 'li', id: 'item0', html: 'List Item 0'},
        {tag: 'li', id: 'item1', html: 'List Item 1'},
        {tag: 'li', id: 'item2', html: 'List Item 2'}
    ]
};
var list = dh.append(
    'my-div', // the context element 'my-div' can either be the id or the actual node
    spec      // the specification object
);
 </code></pre></p>
 * <p>Element creation specification parameters in this class may also be passed as an Array of
 * specification objects. This can be used to insert multiple sibling nodes into an existing
 * container very efficiently. For example, to add more list items to the example above:<pre><code>
dh.append('my-ul', [
    {tag: 'li', id: 'item3', html: 'List Item 3'},
    {tag: 'li', id: 'item4', html: 'List Item 4'}
]);
 * </code></pre></p>
 *
 * <p><b><u>Templating</u></b></p>
 * <p>The real power is in the built-in templating. Instead of creating or appending any elements,
 * <tt>{@link #createTemplate}</tt> returns a Template object which can be used over and over to
 * insert new elements. Revisiting the example above, we could utilize templating this time:
 * <pre><code>
// create the node
var list = dh.append('my-div', {tag: 'ul', cls: 'my-list'});
// get template
var tpl = dh.createTemplate({tag: 'li', id: 'item{0}', html: 'List Item {0}'});

for(var i = 0; i < 5, i++){
    tpl.append(list, [i]); // use template to append to the actual node
}
 * </code></pre></p>
 * <p>An example using a template:<pre><code>
var html = '<a id="{0}" href="{1}" class="nav">{2}</a>';

var tpl = new Ext.core.DomHelper.createTemplate(html);
tpl.append('blog-roll', ['link1', 'http://www.edspencer.net/', "Ed&#39;s Site"]);
tpl.append('blog-roll', ['link2', 'http://www.dustindiaz.com/', "Dustin&#39;s Site"]);
 * </code></pre></p>
 *
 * <p>The same example using named parameters:<pre><code>
var html = '<a id="{id}" href="{url}" class="nav">{text}</a>';

var tpl = new Ext.core.DomHelper.createTemplate(html);
tpl.append('blog-roll', {
    id: 'link1',
    url: 'http://www.edspencer.net/',
    text: "Ed&#39;s Site"
});
tpl.append('blog-roll', {
    id: 'link2',
    url: 'http://www.dustindiaz.com/',
    text: "Dustin&#39;s Site"
});
 * </code></pre></p>
 *
 * <p><b><u>Compiling Templates</u></b></p>
 * <p>Templates are applied using regular expressions. The performance is great, but if
 * you are adding a bunch of DOM elements using the same template, you can increase
 * performance even further by {@link Ext.Template#compile "compiling"} the template.
 * The way "{@link Ext.Template#compile compile()}" works is the template is parsed and
 * broken up at the different variable points and a dynamic function is created and eval'ed.
 * The generated function performs string concatenation of these parts and the passed
 * variables instead of using regular expressions.
 * <pre><code>
var html = '<a id="{id}" href="{url}" class="nav">{text}</a>';

var tpl = new Ext.core.DomHelper.createTemplate(html);
tpl.compile();

//... use template like normal
 * </code></pre></p>
 *
 * <p><b><u>Performance Boost</u></b></p>
 * <p>DomHelper will transparently create HTML fragments when it can. Using HTML fragments instead
 * of DOM can significantly boost performance.</p>
 * <p>Element creation specification parameters may also be strings. If {@link #useDom} is <tt>false</tt>,
 * then the string is used as innerHTML. If {@link #useDom} is <tt>true</tt>, a string specification
 * results in the creation of a text node. Usage:</p>
 * <pre><code>
Ext.core.DomHelper.useDom = true; // force it to use DOM; reduces performance
 * </code></pre>
 * @singleton
 */
Ext.ns('Ext.core');
Ext.core.DomHelper = function(){
    var tempTableEl = null,
        emptyTags = /^(?:br|frame|hr|img|input|link|meta|range|spacer|wbr|area|param|col)$/i,
        tableRe = /^table|tbody|tr|td$/i,
        confRe = /tag|children|cn|html$/i,
        tableElRe = /td|tr|tbody/i,
        endRe = /end/i,
        pub,
        // kill repeat to save bytes
        afterbegin = 'afterbegin',
        afterend = 'afterend',
        beforebegin = 'beforebegin',
        beforeend = 'beforeend',
        ts = '<table>',
        te = '</table>',
        tbs = ts+'<tbody>',
        tbe = '</tbody>'+te,
        trs = tbs + '<tr>',
        tre = '</tr>'+tbe;

    // private
    function doInsert(el, o, returnElement, pos, sibling, append){
        el = Ext.getDom(el);
        var newNode;
        if (pub.useDom) {
            newNode = createDom(o, null);
            if (append) {
                el.appendChild(newNode);
            } else {
                (sibling == 'firstChild' ? el : el.parentNode).insertBefore(newNode, el[sibling] || el);
            }
        } else {
            newNode = Ext.core.DomHelper.insertHtml(pos, el, Ext.core.DomHelper.createHtml(o));
        }
        return returnElement ? Ext.get(newNode, true) : newNode;
    }
    
    function createDom(o, parentNode){
        var el,
            doc = document,
            useSet,
            attr,
            val,
            cn;

        if (Ext.isArray(o)) {                       // Allow Arrays of siblings to be inserted
            el = doc.createDocumentFragment(); // in one shot using a DocumentFragment
            for (var i = 0, l = o.length; i < l; i++) {
                createDom(o[i], el);
            }
        } else if (typeof o == 'string') {         // Allow a string as a child spec.
            el = doc.createTextNode(o);
        } else {
            el = doc.createElement( o.tag || 'div' );
            useSet = !!el.setAttribute; // In IE some elements don't have setAttribute
            for (attr in o) {
                if(!confRe.test(attr)){
                    val = o[attr];
                    if(attr == 'cls'){
                        el.className = val;
                    }else{
                        if(useSet){
                            el.setAttribute(attr, val);
                        }else{
                            el[attr] = val;
                        }
                    }
                }
            }
            Ext.core.DomHelper.applyStyles(el, o.style);

            if ((cn = o.children || o.cn)) {
                createDom(cn, el);
            } else if (o.html) {
                el.innerHTML = o.html;
            }
        }
        if(parentNode){
           parentNode.appendChild(el);
        }
        return el;
    }

    // build as innerHTML where available
    function createHtml(o){
        var b = '',
            attr,
            val,
            key,
            cn,
            i;

        if(typeof o == "string"){
            b = o;
        } else if (Ext.isArray(o)) {
            for (i=0; i < o.length; i++) {
                if(o[i]) {
                    b += createHtml(o[i]);
                }
            }
        } else {
            b += '<' + (o.tag = o.tag || 'div');
            for (attr in o) {
                val = o[attr];
                if(!confRe.test(attr)){
                    if (typeof val == "object") {
                        b += ' ' + attr + '="';
                        for (key in val) {
                            b += key + ':' + val[key] + ';';
                        }
                        b += '"';
                    }else{
                        b += ' ' + ({cls : 'class', htmlFor : 'for'}[attr] || attr) + '="' + val + '"';
                    }
                }
            }
            // Now either just close the tag or try to add children and close the tag.
            if (emptyTags.test(o.tag)) {
                b += '/>';
            } else {
                b += '>';
                if ((cn = o.children || o.cn)) {
                    b += createHtml(cn);
                } else if(o.html){
                    b += o.html;
                }
                b += '</' + o.tag + '>';
            }
        }
        return b;
    }

    function ieTable(depth, s, h, e){
        tempTableEl.innerHTML = [s, h, e].join('');
        var i = -1,
            el = tempTableEl,
            ns;
        while(++i < depth){
            el = el.firstChild;
        }
//      If the result is multiple siblings, then encapsulate them into one fragment.
        ns = el.nextSibling;
        if (ns){
            var df = document.createDocumentFragment();
            while(el){
                ns = el.nextSibling;
                df.appendChild(el);
                el = ns;
            }
            el = df;
        }
        return el;
    }

    /**
     * @ignore
     * Nasty code for IE's broken table implementation
     */
    function insertIntoTable(tag, where, el, html) {
        var node,
            before;

        tempTableEl = tempTableEl || document.createElement('div');

        if(tag == 'td' && (where == afterbegin || where == beforeend) ||
           !tableElRe.test(tag) && (where == beforebegin || where == afterend)) {
            return null;
        }
        before = where == beforebegin ? el :
                 where == afterend ? el.nextSibling :
                 where == afterbegin ? el.firstChild : null;

        if (where == beforebegin || where == afterend) {
            el = el.parentNode;
        }

        if (tag == 'td' || (tag == 'tr' && (where == beforeend || where == afterbegin))) {
            node = ieTable(4, trs, html, tre);
        } else if ((tag == 'tbody' && (where == beforeend || where == afterbegin)) ||
                   (tag == 'tr' && (where == beforebegin || where == afterend))) {
            node = ieTable(3, tbs, html, tbe);
        } else {
            node = ieTable(2, ts, html, te);
        }
        el.insertBefore(node, before);
        return node;
    }
    
    /**
     * @ignore
     * Fix for IE9 createContextualFragment missing method
     */   
    function createContextualFragment(html){
        var div = document.createElement("div"),
            fragment = document.createDocumentFragment(),
            i = 0,
            length, childNodes;
        
        div.innerHTML = html;
        childNodes = div.childNodes;
        length = childNodes.length;

        for (; i < length; i++) {
            fragment.appendChild(childNodes[i].cloneNode(true));
        }

        return fragment;
    }
    
    pub = {
        /**
         * Returns the markup for the passed Element(s) config.
         * @param {Object} o The DOM object spec (and children)
         * @return {String}
         */
        markup : function(o){
            return createHtml(o);
        },

        /**
         * Applies a style specification to an element.
         * @param {String/HTMLElement} el The element to apply styles to
         * @param {String/Object/Function} styles A style specification string e.g. 'width:100px', or object in the form {width:'100px'}, or
         * a function which returns such a specification.
         */
        applyStyles : function(el, styles){
            if (styles) {
                el = Ext.fly(el);
                if (typeof styles == "function") {
                    styles = styles.call();
                }
                if (typeof styles == "string") {
                    styles = Ext.core.Element.parseStyles(styles);
                }
                if (typeof styles == "object") {
                    el.setStyle(styles);
                }
            }
        },

        /**
         * Inserts an HTML fragment into the DOM.
         * @param {String} where Where to insert the html in relation to el - beforeBegin, afterBegin, beforeEnd, afterEnd.
         * @param {HTMLElement/TextNode} el The context element
         * @param {String} html The HTML fragment
         * @return {HTMLElement} The new node
         */
        insertHtml : function(where, el, html){
            var hash = {},
                hashVal,
                range,
                rangeEl,
                setStart,
                frag,
                rs;

            where = where.toLowerCase();
            // add these here because they are used in both branches of the condition.
            hash[beforebegin] = ['BeforeBegin', 'previousSibling'];
            hash[afterend] = ['AfterEnd', 'nextSibling'];
            
            // if IE and context element is an HTMLElement
            if (el.insertAdjacentHTML) {
                if(tableRe.test(el.tagName) && (rs = insertIntoTable(el.tagName.toLowerCase(), where, el, html))){
                    return rs;
                }
                
                // add these two to the hash.
                hash[afterbegin] = ['AfterBegin', 'firstChild'];
                hash[beforeend] = ['BeforeEnd', 'lastChild'];
                if ((hashVal = hash[where])) {
                    el.insertAdjacentHTML(hashVal[0], html);
                    return el[hashVal[1]];
                }
            // if (not IE and context element is an HTMLElement) or TextNode
            } else {
                // we cannot insert anything inside a textnode so...
                if (Ext.isTextNode(el)) {
                    where = where === 'afterbegin' ? 'beforebegin' : where; 
                    where = where === 'beforeend' ? 'afterend' : where;
                }
                range = Ext.supports.CreateContextualFragment ? el.ownerDocument.createRange() : undefined;
                setStart = 'setStart' + (endRe.test(where) ? 'After' : 'Before');
                if (hash[where]) {
                    if (range) {
                        range[setStart](el);
                        frag = range.createContextualFragment(html);
                    } else {
                        frag = createContextualFragment(html);
                    }
                    el.parentNode.insertBefore(frag, where == beforebegin ? el : el.nextSibling);
                    return el[(where == beforebegin ? 'previous' : 'next') + 'Sibling'];
                } else {
                    rangeEl = (where == afterbegin ? 'first' : 'last') + 'Child';
                    if (el.firstChild) {
                        if (range) {
                            range[setStart](el[rangeEl]);
                            frag = range.createContextualFragment(html);
                        } else {
                            frag = createContextualFragment(html);
                        }
                        
                        if(where == afterbegin){
                            el.insertBefore(frag, el.firstChild);
                        }else{
                            el.appendChild(frag);
                        }
                    } else {
                        el.innerHTML = html;
                    }
                    return el[rangeEl];
                }
            }
            //<debug>
            Ext.Error.raise({
                sourceClass: 'Ext.core.DomHelper',
                sourceMethod: 'insertHtml',
                htmlToInsert: html,
                targetElement: el,
                msg: 'Illegal insertion point reached: "' + where + '"'
            });
            //</debug>
        },

        /**
         * Creates new DOM element(s) and inserts them before el.
         * @param {Mixed} el The context element
         * @param {Object/String} o The DOM object spec (and children) or raw HTML blob
         * @param {Boolean} returnElement (optional) true to return a Ext.core.Element
         * @return {HTMLElement/Ext.core.Element} The new node
         */
        insertBefore : function(el, o, returnElement){
            return doInsert(el, o, returnElement, beforebegin);
        },

        /**
         * Creates new DOM element(s) and inserts them after el.
         * @param {Mixed} el The context element
         * @param {Object} o The DOM object spec (and children)
         * @param {Boolean} returnElement (optional) true to return a Ext.core.Element
         * @return {HTMLElement/Ext.core.Element} The new node
         */
        insertAfter : function(el, o, returnElement){
            return doInsert(el, o, returnElement, afterend, 'nextSibling');
        },

        /**
         * Creates new DOM element(s) and inserts them as the first child of el.
         * @param {Mixed} el The context element
         * @param {Object/String} o The DOM object spec (and children) or raw HTML blob
         * @param {Boolean} returnElement (optional) true to return a Ext.core.Element
         * @return {HTMLElement/Ext.core.Element} The new node
         */
        insertFirst : function(el, o, returnElement){
            return doInsert(el, o, returnElement, afterbegin, 'firstChild');
        },

        /**
         * Creates new DOM element(s) and appends them to el.
         * @param {Mixed} el The context element
         * @param {Object/String} o The DOM object spec (and children) or raw HTML blob
         * @param {Boolean} returnElement (optional) true to return a Ext.core.Element
         * @return {HTMLElement/Ext.core.Element} The new node
         */
        append : function(el, o, returnElement){
            return doInsert(el, o, returnElement, beforeend, '', true);
        },

        /**
         * Creates new DOM element(s) and overwrites the contents of el with them.
         * @param {Mixed} el The context element
         * @param {Object/String} o The DOM object spec (and children) or raw HTML blob
         * @param {Boolean} returnElement (optional) true to return a Ext.core.Element
         * @return {HTMLElement/Ext.core.Element} The new node
         */
        overwrite : function(el, o, returnElement){
            el = Ext.getDom(el);
            el.innerHTML = createHtml(o);
            return returnElement ? Ext.get(el.firstChild) : el.firstChild;
        },

        createHtml : createHtml,
        
        /**
         * Creates new DOM element(s) without inserting them to the document.
         * @param {Object/String} o The DOM object spec (and children) or raw HTML blob
         * @return {HTMLElement} The new uninserted node
         * @method
         */
        createDom: createDom,
        
        /** True to force the use of DOM instead of html fragments @type Boolean */
        useDom : false,
        
        /**
         * Creates a new Ext.Template from the DOM object spec.
         * @param {Object} o The DOM object spec (and children)
         * @return {Ext.Template} The new template
         */
        createTemplate : function(o){
            var html = Ext.core.DomHelper.createHtml(o);
            return Ext.create('Ext.Template', html);
        }
    };
    return pub;
}();

/*
 * This is code is also distributed under MIT license for use
 * with jQuery and prototype JavaScript libraries.
 */
/**
 * @class Ext.DomQuery
Provides high performance selector/xpath processing by compiling queries into reusable functions. New pseudo classes and matchers can be plugged. It works on HTML and XML documents (if a content node is passed in).
<p>
DomQuery supports most of the <a href="http://www.w3.org/TR/2005/WD-css3-selectors-20051215/#selectors">CSS3 selectors spec</a>, along with some custom selectors and basic XPath.</p>

<p>
All selectors, attribute filters and pseudos below can be combined infinitely in any order. For example "div.foo:nth-child(odd)[@foo=bar].bar:first" would be a perfectly valid selector. Node filters are processed in the order in which they appear, which allows you to optimize your queries for your document structure.
</p>
<h4>Element Selectors:</h4>
<ul class="list">
    <li> <b>*</b> any element</li>
    <li> <b>E</b> an element with the tag E</li>
    <li> <b>E F</b> All descendent elements of E that have the tag F</li>
    <li> <b>E > F</b> or <b>E/F</b> all direct children elements of E that have the tag F</li>
    <li> <b>E + F</b> all elements with the tag F that are immediately preceded by an element with the tag E</li>
    <li> <b>E ~ F</b> all elements with the tag F that are preceded by a sibling element with the tag E</li>
</ul>
<h4>Attribute Selectors:</h4>
<p>The use of &#64; and quotes are optional. For example, div[&#64;foo='bar'] is also a valid attribute selector.</p>
<ul class="list">
    <li> <b>E[foo]</b> has an attribute "foo"</li>
    <li> <b>E[foo=bar]</b> has an attribute "foo" that equals "bar"</li>
    <li> <b>E[foo^=bar]</b> has an attribute "foo" that starts with "bar"</li>
    <li> <b>E[foo$=bar]</b> has an attribute "foo" that ends with "bar"</li>
    <li> <b>E[foo*=bar]</b> has an attribute "foo" that contains the substring "bar"</li>
    <li> <b>E[foo%=2]</b> has an attribute "foo" that is evenly divisible by 2</li>
    <li> <b>E[foo!=bar]</b> attribute "foo" does not equal "bar"</li>
</ul>
<h4>Pseudo Classes:</h4>
<ul class="list">
    <li> <b>E:first-child</b> E is the first child of its parent</li>
    <li> <b>E:last-child</b> E is the last child of its parent</li>
    <li> <b>E:nth-child(<i>n</i>)</b> E is the <i>n</i>th child of its parent (1 based as per the spec)</li>
    <li> <b>E:nth-child(odd)</b> E is an odd child of its parent</li>
    <li> <b>E:nth-child(even)</b> E is an even child of its parent</li>
    <li> <b>E:only-child</b> E is the only child of its parent</li>
    <li> <b>E:checked</b> E is an element that is has a checked attribute that is true (e.g. a radio or checkbox) </li>
    <li> <b>E:first</b> the first E in the resultset</li>
    <li> <b>E:last</b> the last E in the resultset</li>
    <li> <b>E:nth(<i>n</i>)</b> the <i>n</i>th E in the resultset (1 based)</li>
    <li> <b>E:odd</b> shortcut for :nth-child(odd)</li>
    <li> <b>E:even</b> shortcut for :nth-child(even)</li>
    <li> <b>E:contains(foo)</b> E's innerHTML contains the substring "foo"</li>
    <li> <b>E:nodeValue(foo)</b> E contains a textNode with a nodeValue that equals "foo"</li>
    <li> <b>E:not(S)</b> an E element that does not match simple selector S</li>
    <li> <b>E:has(S)</b> an E element that has a descendent that matches simple selector S</li>
    <li> <b>E:next(S)</b> an E element whose next sibling matches simple selector S</li>
    <li> <b>E:prev(S)</b> an E element whose previous sibling matches simple selector S</li>
    <li> <b>E:any(S1|S2|S2)</b> an E element which matches any of the simple selectors S1, S2 or S3//\\</li>
</ul>
<h4>CSS Value Selectors:</h4>
<ul class="list">
    <li> <b>E{display=none}</b> css value "display" that equals "none"</li>
    <li> <b>E{display^=none}</b> css value "display" that starts with "none"</li>
    <li> <b>E{display$=none}</b> css value "display" that ends with "none"</li>
    <li> <b>E{display*=none}</b> css value "display" that contains the substring "none"</li>
    <li> <b>E{display%=2}</b> css value "display" that is evenly divisible by 2</li>
    <li> <b>E{display!=none}</b> css value "display" that does not equal "none"</li>
</ul>
 * @singleton
 */
Ext.ns('Ext.core');

Ext.core.DomQuery = Ext.DomQuery = function(){
    var cache = {},
        simpleCache = {},
        valueCache = {},
        nonSpace = /\S/,
        trimRe = /^\s+|\s+$/g,
        tplRe = /\{(\d+)\}/g,
        modeRe = /^(\s?[\/>+~]\s?|\s|$)/,
        tagTokenRe = /^(#)?([\w-\*]+)/,
        nthRe = /(\d*)n\+?(\d*)/,
        nthRe2 = /\D/,
        // This is for IE MSXML which does not support expandos.
    // IE runs the same speed using setAttribute, however FF slows way down
    // and Safari completely fails so they need to continue to use expandos.
    isIE = window.ActiveXObject ? true : false,
    key = 30803;

    // this eval is stop the compressor from
    // renaming the variable to something shorter
    eval("var batch = 30803;");

    // Retrieve the child node from a particular
    // parent at the specified index.
    function child(parent, index){
        var i = 0,
            n = parent.firstChild;
        while(n){
            if(n.nodeType == 1){
               if(++i == index){
                   return n;
               }
            }
            n = n.nextSibling;
        }
        return null;
    }

    // retrieve the next element node
    function next(n){
        while((n = n.nextSibling) && n.nodeType != 1);
        return n;
    }

    // retrieve the previous element node
    function prev(n){
        while((n = n.previousSibling) && n.nodeType != 1);
        return n;
    }

    // Mark each child node with a nodeIndex skipping and
    // removing empty text nodes.
    function children(parent){
        var n = parent.firstChild,
        nodeIndex = -1,
        nextNode;
        while(n){
            nextNode = n.nextSibling;
            // clean worthless empty nodes.
            if(n.nodeType == 3 && !nonSpace.test(n.nodeValue)){
            parent.removeChild(n);
            }else{
            // add an expando nodeIndex
            n.nodeIndex = ++nodeIndex;
            }
            n = nextNode;
        }
        return this;
    }


    // nodeSet - array of nodes
    // cls - CSS Class
    function byClassName(nodeSet, cls){
        if(!cls){
            return nodeSet;
        }
        var result = [], ri = -1;
        for(var i = 0, ci; ci = nodeSet[i]; i++){
            if((' '+ci.className+' ').indexOf(cls) != -1){
                result[++ri] = ci;
            }
        }
        return result;
    };

    function attrValue(n, attr){
        // if its an array, use the first node.
        if(!n.tagName && typeof n.length != "undefined"){
            n = n[0];
        }
        if(!n){
            return null;
        }

        if(attr == "for"){
            return n.htmlFor;
        }
        if(attr == "class" || attr == "className"){
            return n.className;
        }
        return n.getAttribute(attr) || n[attr];

    };


    // ns - nodes
    // mode - false, /, >, +, ~
    // tagName - defaults to "*"
    function getNodes(ns, mode, tagName){
        var result = [], ri = -1, cs;
        if(!ns){
            return result;
        }
        tagName = tagName || "*";
        // convert to array
        if(typeof ns.getElementsByTagName != "undefined"){
            ns = [ns];
        }

        // no mode specified, grab all elements by tagName
        // at any depth
        if(!mode){
            for(var i = 0, ni; ni = ns[i]; i++){
                cs = ni.getElementsByTagName(tagName);
                for(var j = 0, ci; ci = cs[j]; j++){
                    result[++ri] = ci;
                }
            }
        // Direct Child mode (/ or >)
        // E > F or E/F all direct children elements of E that have the tag
        } else if(mode == "/" || mode == ">"){
            var utag = tagName.toUpperCase();
            for(var i = 0, ni, cn; ni = ns[i]; i++){
                cn = ni.childNodes;
                for(var j = 0, cj; cj = cn[j]; j++){
                    if(cj.nodeName == utag || cj.nodeName == tagName  || tagName == '*'){
                        result[++ri] = cj;
                    }
                }
            }
        // Immediately Preceding mode (+)
        // E + F all elements with the tag F that are immediately preceded by an element with the tag E
        }else if(mode == "+"){
            var utag = tagName.toUpperCase();
            for(var i = 0, n; n = ns[i]; i++){
                while((n = n.nextSibling) && n.nodeType != 1);
                if(n && (n.nodeName == utag || n.nodeName == tagName || tagName == '*')){
                    result[++ri] = n;
                }
            }
        // Sibling mode (~)
        // E ~ F all elements with the tag F that are preceded by a sibling element with the tag E
        }else if(mode == "~"){
            var utag = tagName.toUpperCase();
            for(var i = 0, n; n = ns[i]; i++){
                while((n = n.nextSibling)){
                    if (n.nodeName == utag || n.nodeName == tagName || tagName == '*'){
                        result[++ri] = n;
                    }
                }
            }
        }
        return result;
    }

    function concat(a, b){
        if(b.slice){
            return a.concat(b);
        }
        for(var i = 0, l = b.length; i < l; i++){
            a[a.length] = b[i];
        }
        return a;
    }

    function byTag(cs, tagName){
        if(cs.tagName || cs == document){
            cs = [cs];
        }
        if(!tagName){
            return cs;
        }
        var result = [], ri = -1;
        tagName = tagName.toLowerCase();
        for(var i = 0, ci; ci = cs[i]; i++){
            if(ci.nodeType == 1 && ci.tagName.toLowerCase() == tagName){
                result[++ri] = ci;
            }
        }
        return result;
    }

    function byId(cs, id){
        if(cs.tagName || cs == document){
            cs = [cs];
        }
        if(!id){
            return cs;
        }
        var result = [], ri = -1;
        for(var i = 0, ci; ci = cs[i]; i++){
            if(ci && ci.id == id){
                result[++ri] = ci;
                return result;
            }
        }
        return result;
    }

    // operators are =, !=, ^=, $=, *=, %=, |= and ~=
    // custom can be "{"
    function byAttribute(cs, attr, value, op, custom){
        var result = [],
            ri = -1,
            useGetStyle = custom == "{",
            fn = Ext.DomQuery.operators[op],
            a,
            xml,
            hasXml;

        for(var i = 0, ci; ci = cs[i]; i++){
            // skip non-element nodes.
            if(ci.nodeType != 1){
                continue;
            }
            // only need to do this for the first node
            if(!hasXml){
                xml = Ext.DomQuery.isXml(ci);
                hasXml = true;
            }

            // we only need to change the property names if we're dealing with html nodes, not XML
            if(!xml){
                if(useGetStyle){
                    a = Ext.DomQuery.getStyle(ci, attr);
                } else if (attr == "class" || attr == "className"){
                    a = ci.className;
                } else if (attr == "for"){
                    a = ci.htmlFor;
                } else if (attr == "href"){
                    // getAttribute href bug
                    // http://www.glennjones.net/Post/809/getAttributehrefbug.htm
                    a = ci.getAttribute("href", 2);
                } else{
                    a = ci.getAttribute(attr);
                }
            }else{
                a = ci.getAttribute(attr);
            }
            if((fn && fn(a, value)) || (!fn && a)){
                result[++ri] = ci;
            }
        }
        return result;
    }

    function byPseudo(cs, name, value){
        return Ext.DomQuery.pseudos[name](cs, value);
    }

    function nodupIEXml(cs){
        var d = ++key,
            r;
        cs[0].setAttribute("_nodup", d);
        r = [cs[0]];
        for(var i = 1, len = cs.length; i < len; i++){
            var c = cs[i];
            if(!c.getAttribute("_nodup") != d){
                c.setAttribute("_nodup", d);
                r[r.length] = c;
            }
        }
        for(var i = 0, len = cs.length; i < len; i++){
            cs[i].removeAttribute("_nodup");
        }
        return r;
    }

    function nodup(cs){
        if(!cs){
            return [];
        }
        var len = cs.length, c, i, r = cs, cj, ri = -1;
        if(!len || typeof cs.nodeType != "undefined" || len == 1){
            return cs;
        }
        if(isIE && typeof cs[0].selectSingleNode != "undefined"){
            return nodupIEXml(cs);
        }
        var d = ++key;
        cs[0]._nodup = d;
        for(i = 1; c = cs[i]; i++){
            if(c._nodup != d){
                c._nodup = d;
            }else{
                r = [];
                for(var j = 0; j < i; j++){
                    r[++ri] = cs[j];
                }
                for(j = i+1; cj = cs[j]; j++){
                    if(cj._nodup != d){
                        cj._nodup = d;
                        r[++ri] = cj;
                    }
                }
                return r;
            }
        }
        return r;
    }

    function quickDiffIEXml(c1, c2){
        var d = ++key,
            r = [];
        for(var i = 0, len = c1.length; i < len; i++){
            c1[i].setAttribute("_qdiff", d);
        }
        for(var i = 0, len = c2.length; i < len; i++){
            if(c2[i].getAttribute("_qdiff") != d){
                r[r.length] = c2[i];
            }
        }
        for(var i = 0, len = c1.length; i < len; i++){
           c1[i].removeAttribute("_qdiff");
        }
        return r;
    }

    function quickDiff(c1, c2){
        var len1 = c1.length,
            d = ++key,
            r = [];
        if(!len1){
            return c2;
        }
        if(isIE && typeof c1[0].selectSingleNode != "undefined"){
            return quickDiffIEXml(c1, c2);
        }
        for(var i = 0; i < len1; i++){
            c1[i]._qdiff = d;
        }
        for(var i = 0, len = c2.length; i < len; i++){
            if(c2[i]._qdiff != d){
                r[r.length] = c2[i];
            }
        }
        return r;
    }

    function quickId(ns, mode, root, id){
        if(ns == root){
           var d = root.ownerDocument || root;
           return d.getElementById(id);
        }
        ns = getNodes(ns, mode, "*");
        return byId(ns, id);
    }

    return {
        getStyle : function(el, name){
            return Ext.fly(el).getStyle(name);
        },
        /**
         * Compiles a selector/xpath query into a reusable function. The returned function
         * takes one parameter "root" (optional), which is the context node from where the query should start.
         * @param {String} selector The selector/xpath query
         * @param {String} type (optional) Either "select" (the default) or "simple" for a simple selector match
         * @return {Function}
         */
        compile : function(path, type){
            type = type || "select";

            // setup fn preamble
            var fn = ["var f = function(root){\n var mode; ++batch; var n = root || document;\n"],
                mode,
                lastPath,
                matchers = Ext.DomQuery.matchers,
                matchersLn = matchers.length,
                modeMatch,
                // accept leading mode switch
                lmode = path.match(modeRe);

            if(lmode && lmode[1]){
                fn[fn.length] = 'mode="'+lmode[1].replace(trimRe, "")+'";';
                path = path.replace(lmode[1], "");
            }

            // strip leading slashes
            while(path.substr(0, 1)=="/"){
                path = path.substr(1);
            }

            while(path && lastPath != path){
                lastPath = path;
                var tokenMatch = path.match(tagTokenRe);
                if(type == "select"){
                    if(tokenMatch){
                        // ID Selector
                        if(tokenMatch[1] == "#"){
                            fn[fn.length] = 'n = quickId(n, mode, root, "'+tokenMatch[2]+'");';
                        }else{
                            fn[fn.length] = 'n = getNodes(n, mode, "'+tokenMatch[2]+'");';
                        }
                        path = path.replace(tokenMatch[0], "");
                    }else if(path.substr(0, 1) != '@'){
                        fn[fn.length] = 'n = getNodes(n, mode, "*");';
                    }
                // type of "simple"
                }else{
                    if(tokenMatch){
                        if(tokenMatch[1] == "#"){
                            fn[fn.length] = 'n = byId(n, "'+tokenMatch[2]+'");';
                        }else{
                            fn[fn.length] = 'n = byTag(n, "'+tokenMatch[2]+'");';
                        }
                        path = path.replace(tokenMatch[0], "");
                    }
                }
                while(!(modeMatch = path.match(modeRe))){
                    var matched = false;
                    for(var j = 0; j < matchersLn; j++){
                        var t = matchers[j];
                        var m = path.match(t.re);
                        if(m){
                            fn[fn.length] = t.select.replace(tplRe, function(x, i){
                                return m[i];
                            });
                            path = path.replace(m[0], "");
                            matched = true;
                            break;
                        }
                    }
                    // prevent infinite loop on bad selector
                    if(!matched){
                        //<debug>
                        Ext.Error.raise({
                            sourceClass: 'Ext.DomQuery',
                            sourceMethod: 'compile',
                            msg: 'Error parsing selector. Parsing failed at "' + path + '"'
                        });
                        //</debug>
                    }
                }
                if(modeMatch[1]){
                    fn[fn.length] = 'mode="'+modeMatch[1].replace(trimRe, "")+'";';
                    path = path.replace(modeMatch[1], "");
                }
            }
            // close fn out
            fn[fn.length] = "return nodup(n);\n}";

            // eval fn and return it
            eval(fn.join(""));
            return f;
        },

        /**
         * Selects an array of DOM nodes using JavaScript-only implementation.
         *
         * Use {@link #select} to take advantage of browsers built-in support for CSS selectors.
         *
         * @param {String} selector The selector/xpath query (can be a comma separated list of selectors)
         * @param {Node/String} root (optional) The start of the query (defaults to document).
         * @return {Array} An Array of DOM elements which match the selector. If there are
         * no matches, and empty Array is returned.
         */
        jsSelect: function(path, root, type){
            // set root to doc if not specified.
            root = root || document;

            if(typeof root == "string"){
                root = document.getElementById(root);
            }
            var paths = path.split(","),
                results = [];

            // loop over each selector
            for(var i = 0, len = paths.length; i < len; i++){
                var subPath = paths[i].replace(trimRe, "");
                // compile and place in cache
                if(!cache[subPath]){
                    cache[subPath] = Ext.DomQuery.compile(subPath);
                    if(!cache[subPath]){
                        //<debug>
                        Ext.Error.raise({
                            sourceClass: 'Ext.DomQuery',
                            sourceMethod: 'jsSelect',
                            msg: subPath + ' is not a valid selector'
                        });
                        //</debug>
                    }
                }
                var result = cache[subPath](root);
                if(result && result != document){
                    results = results.concat(result);
                }
            }

            // if there were multiple selectors, make sure dups
            // are eliminated
            if(paths.length > 1){
                return nodup(results);
            }
            return results;
        },

        isXml: function(el) {
            var docEl = (el ? el.ownerDocument || el : 0).documentElement;
            return docEl ? docEl.nodeName !== "HTML" : false;
        },

        /**
         * Selects an array of DOM nodes by CSS/XPath selector.
         *
         * Uses [document.querySelectorAll][0] if browser supports that, otherwise falls back to
         * {@link #jsSelect} to do the work.
         * 
         * Aliased as {@link Ext#query}.
         * 
         * [0]: https://developer.mozilla.org/en/DOM/document.querySelectorAll
         *
         * @param {String} path The selector/xpath query
         * @param {Node} root (optional) The start of the query (defaults to document).
         * @return {Array} An array of DOM elements (not a NodeList as returned by `querySelectorAll`).
         * Empty array when no matches.
         * @method
         */
        select : document.querySelectorAll ? function(path, root, type) {
            root = root || document;
            if (!Ext.DomQuery.isXml(root)) {
            try {
                var cs = root.querySelectorAll(path);
                return Ext.Array.toArray(cs);
            }
            catch (ex) {}
            }
            return Ext.DomQuery.jsSelect.call(this, path, root, type);
        } : function(path, root, type) {
            return Ext.DomQuery.jsSelect.call(this, path, root, type);
        },

        /**
         * Selects a single element.
         * @param {String} selector The selector/xpath query
         * @param {Node} root (optional) The start of the query (defaults to document).
         * @return {Element} The DOM element which matched the selector.
         */
        selectNode : function(path, root){
            return Ext.DomQuery.select(path, root)[0];
        },

        /**
         * Selects the value of a node, optionally replacing null with the defaultValue.
         * @param {String} selector The selector/xpath query
         * @param {Node} root (optional) The start of the query (defaults to document).
         * @param {String} defaultValue
         * @return {String}
         */
        selectValue : function(path, root, defaultValue){
            path = path.replace(trimRe, "");
            if(!valueCache[path]){
                valueCache[path] = Ext.DomQuery.compile(path, "select");
            }
            var n = valueCache[path](root), v;
            n = n[0] ? n[0] : n;

            // overcome a limitation of maximum textnode size
            // Rumored to potentially crash IE6 but has not been confirmed.
            // http://reference.sitepoint.com/javascript/Node/normalize
            // https://developer.mozilla.org/En/DOM/Node.normalize
            if (typeof n.normalize == 'function') n.normalize();

            v = (n && n.firstChild ? n.firstChild.nodeValue : null);
            return ((v === null||v === undefined||v==='') ? defaultValue : v);
        },

        /**
         * Selects the value of a node, parsing integers and floats. Returns the defaultValue, or 0 if none is specified.
         * @param {String} selector The selector/xpath query
         * @param {Node} root (optional) The start of the query (defaults to document).
         * @param {Number} defaultValue
         * @return {Number}
         */
        selectNumber : function(path, root, defaultValue){
            var v = Ext.DomQuery.selectValue(path, root, defaultValue || 0);
            return parseFloat(v);
        },

        /**
         * Returns true if the passed element(s) match the passed simple selector (e.g. div.some-class or span:first-child)
         * @param {String/HTMLElement/Array} el An element id, element or array of elements
         * @param {String} selector The simple selector to test
         * @return {Boolean}
         */
        is : function(el, ss){
            if(typeof el == "string"){
                el = document.getElementById(el);
            }
            var isArray = Ext.isArray(el),
                result = Ext.DomQuery.filter(isArray ? el : [el], ss);
            return isArray ? (result.length == el.length) : (result.length > 0);
        },

        /**
         * Filters an array of elements to only include matches of a simple selector (e.g. div.some-class or span:first-child)
         * @param {Array} el An array of elements to filter
         * @param {String} selector The simple selector to test
         * @param {Boolean} nonMatches If true, it returns the elements that DON'T match
         * the selector instead of the ones that match
         * @return {Array} An Array of DOM elements which match the selector. If there are
         * no matches, and empty Array is returned.
         */
        filter : function(els, ss, nonMatches){
            ss = ss.replace(trimRe, "");
            if(!simpleCache[ss]){
                simpleCache[ss] = Ext.DomQuery.compile(ss, "simple");
            }
            var result = simpleCache[ss](els);
            return nonMatches ? quickDiff(result, els) : result;
        },

        /**
         * Collection of matching regular expressions and code snippets.
         * Each capture group within () will be replace the {} in the select
         * statement as specified by their index.
         */
        matchers : [{
                re: /^\.([\w-]+)/,
                select: 'n = byClassName(n, " {1} ");'
            }, {
                re: /^\:([\w-]+)(?:\(((?:[^\s>\/]*|.*?))\))?/,
                select: 'n = byPseudo(n, "{1}", "{2}");'
            },{
                re: /^(?:([\[\{])(?:@)?([\w-]+)\s?(?:(=|.=)\s?['"]?(.*?)["']?)?[\]\}])/,
                select: 'n = byAttribute(n, "{2}", "{4}", "{3}", "{1}");'
            }, {
                re: /^#([\w-]+)/,
                select: 'n = byId(n, "{1}");'
            },{
                re: /^@([\w-]+)/,
                select: 'return {firstChild:{nodeValue:attrValue(n, "{1}")}};'
            }
        ],

        /**
         * Collection of operator comparison functions. The default operators are =, !=, ^=, $=, *=, %=, |= and ~=.
         * New operators can be added as long as the match the format <i>c</i>= where <i>c</i> is any character other than space, &gt; &lt;.
         */
        operators : {
            "=" : function(a, v){
                return a == v;
            },
            "!=" : function(a, v){
                return a != v;
            },
            "^=" : function(a, v){
                return a && a.substr(0, v.length) == v;
            },
            "$=" : function(a, v){
                return a && a.substr(a.length-v.length) == v;
            },
            "*=" : function(a, v){
                return a && a.indexOf(v) !== -1;
            },
            "%=" : function(a, v){
                return (a % v) == 0;
            },
            "|=" : function(a, v){
                return a && (a == v || a.substr(0, v.length+1) == v+'-');
            },
            "~=" : function(a, v){
                return a && (' '+a+' ').indexOf(' '+v+' ') != -1;
            }
        },

        /**
Object hash of "pseudo class" filter functions which are used when filtering selections. 
Each function is passed two parameters:

- **c** : Array
    An Array of DOM elements to filter.
    
- **v** : String
    The argument (if any) supplied in the selector.

A filter function returns an Array of DOM elements which conform to the pseudo class.
In addition to the provided pseudo classes listed above such as `first-child` and `nth-child`,
developers may add additional, custom psuedo class filters to select elements according to application-specific requirements.

For example, to filter `a` elements to only return links to __external__ resources:

    Ext.DomQuery.pseudos.external = function(c, v){
        var r = [], ri = -1;
        for(var i = 0, ci; ci = c[i]; i++){
            // Include in result set only if it's a link to an external resource
            if(ci.hostname != location.hostname){
                r[++ri] = ci;
            }
        }
        return r;
    };

Then external links could be gathered with the following statement:

    var externalLinks = Ext.select("a:external");

        * @markdown
        */
        pseudos : {
            "first-child" : function(c){
                var r = [], ri = -1, n;
                for(var i = 0, ci; ci = n = c[i]; i++){
                    while((n = n.previousSibling) && n.nodeType != 1);
                    if(!n){
                        r[++ri] = ci;
                    }
                }
                return r;
            },

            "last-child" : function(c){
                var r = [], ri = -1, n;
                for(var i = 0, ci; ci = n = c[i]; i++){
                    while((n = n.nextSibling) && n.nodeType != 1);
                    if(!n){
                        r[++ri] = ci;
                    }
                }
                return r;
            },

            "nth-child" : function(c, a) {
                var r = [], ri = -1,
                    m = nthRe.exec(a == "even" && "2n" || a == "odd" && "2n+1" || !nthRe2.test(a) && "n+" + a || a),
                    f = (m[1] || 1) - 0, l = m[2] - 0;
                for(var i = 0, n; n = c[i]; i++){
                    var pn = n.parentNode;
                    if (batch != pn._batch) {
                        var j = 0;
                        for(var cn = pn.firstChild; cn; cn = cn.nextSibling){
                            if(cn.nodeType == 1){
                               cn.nodeIndex = ++j;
                            }
                        }
                        pn._batch = batch;
                    }
                    if (f == 1) {
                        if (l == 0 || n.nodeIndex == l){
                            r[++ri] = n;
                        }
                    } else if ((n.nodeIndex + l) % f == 0){
                        r[++ri] = n;
                    }
                }

                return r;
            },

            "only-child" : function(c){
                var r = [], ri = -1;;
                for(var i = 0, ci; ci = c[i]; i++){
                    if(!prev(ci) && !next(ci)){
                        r[++ri] = ci;
                    }
                }
                return r;
            },

            "empty" : function(c){
                var r = [], ri = -1;
                for(var i = 0, ci; ci = c[i]; i++){
                    var cns = ci.childNodes, j = 0, cn, empty = true;
                    while(cn = cns[j]){
                        ++j;
                        if(cn.nodeType == 1 || cn.nodeType == 3){
                            empty = false;
                            break;
                        }
                    }
                    if(empty){
                        r[++ri] = ci;
                    }
                }
                return r;
            },

            "contains" : function(c, v){
                var r = [], ri = -1;
                for(var i = 0, ci; ci = c[i]; i++){
                    if((ci.textContent||ci.innerText||'').indexOf(v) != -1){
                        r[++ri] = ci;
                    }
                }
                return r;
            },

            "nodeValue" : function(c, v){
                var r = [], ri = -1;
                for(var i = 0, ci; ci = c[i]; i++){
                    if(ci.firstChild && ci.firstChild.nodeValue == v){
                        r[++ri] = ci;
                    }
                }
                return r;
            },

            "checked" : function(c){
                var r = [], ri = -1;
                for(var i = 0, ci; ci = c[i]; i++){
                    if(ci.checked == true){
                        r[++ri] = ci;
                    }
                }
                return r;
            },

            "not" : function(c, ss){
                return Ext.DomQuery.filter(c, ss, true);
            },

            "any" : function(c, selectors){
                var ss = selectors.split('|'),
                    r = [], ri = -1, s;
                for(var i = 0, ci; ci = c[i]; i++){
                    for(var j = 0; s = ss[j]; j++){
                        if(Ext.DomQuery.is(ci, s)){
                            r[++ri] = ci;
                            break;
                        }
                    }
                }
                return r;
            },

            "odd" : function(c){
                return this["nth-child"](c, "odd");
            },

            "even" : function(c){
                return this["nth-child"](c, "even");
            },

            "nth" : function(c, a){
                return c[a-1] || [];
            },

            "first" : function(c){
                return c[0] || [];
            },

            "last" : function(c){
                return c[c.length-1] || [];
            },

            "has" : function(c, ss){
                var s = Ext.DomQuery.select,
                    r = [], ri = -1;
                for(var i = 0, ci; ci = c[i]; i++){
                    if(s(ss, ci).length > 0){
                        r[++ri] = ci;
                    }
                }
                return r;
            },

            "next" : function(c, ss){
                var is = Ext.DomQuery.is,
                    r = [], ri = -1;
                for(var i = 0, ci; ci = c[i]; i++){
                    var n = next(ci);
                    if(n && is(n, ss)){
                        r[++ri] = ci;
                    }
                }
                return r;
            },

            "prev" : function(c, ss){
                var is = Ext.DomQuery.is,
                    r = [], ri = -1;
                for(var i = 0, ci; ci = c[i]; i++){
                    var n = prev(ci);
                    if(n && is(n, ss)){
                        r[++ri] = ci;
                    }
                }
                return r;
            }
        }
    };
}();

/**
 * Selects an array of DOM nodes by CSS/XPath selector. Shorthand of {@link Ext.DomQuery#select}
 * @param {String} path The selector/xpath query
 * @param {Node} root (optional) The start of the query (defaults to document).
 * @return {Array}
 * @member Ext
 * @method query
 */
Ext.query = Ext.DomQuery.select;

/**
 * @class Ext.core.Element
 * <p>Encapsulates a DOM element, adding simple DOM manipulation facilities, normalizing for browser differences.</p>
 * <p>All instances of this class inherit the methods of {@link Ext.fx.Anim} making visual effects easily available to all DOM elements.</p>
 * <p>Note that the events documented in this class are not Ext events, they encapsulate browser events. To
 * access the underlying browser event, see {@link Ext.EventObject#browserEvent}. Some older
 * browsers may not support the full range of events. Which events are supported is beyond the control of ExtJs.</p>
 * Usage:<br>
<pre><code>
// by id
var el = Ext.get("my-div");

// by DOM element reference
var el = Ext.get(myDivElement);
</code></pre>
 * <b>Animations</b><br />
 * <p>When an element is manipulated, by default there is no animation.</p>
 * <pre><code>
var el = Ext.get("my-div");

// no animation
el.setWidth(100);
 * </code></pre>
 * <p>Many of the functions for manipulating an element have an optional "animate" parameter.  This
 * parameter can be specified as boolean (<tt>true</tt>) for default animation effects.</p>
 * <pre><code>
// default animation
el.setWidth(100, true);
 * </code></pre>
 *
 * <p>To configure the effects, an object literal with animation options to use as the Element animation
 * configuration object can also be specified. Note that the supported Element animation configuration
 * options are a subset of the {@link Ext.fx.Anim} animation options specific to Fx effects.  The supported
 * Element animation configuration options are:</p>
<pre>
Option    Default   Description
--------- --------  ---------------------------------------------
{@link Ext.fx.Anim#duration duration}  .35       The duration of the animation in seconds
{@link Ext.fx.Anim#easing easing}    easeOut   The easing method
{@link Ext.fx.Anim#callback callback}  none      A function to execute when the anim completes
{@link Ext.fx.Anim#scope scope}     this      The scope (this) of the callback function
</pre>
 *
 * <pre><code>
// Element animation options object
var opt = {
    {@link Ext.fx.Anim#duration duration}: 1,
    {@link Ext.fx.Anim#easing easing}: 'elasticIn',
    {@link Ext.fx.Anim#callback callback}: this.foo,
    {@link Ext.fx.Anim#scope scope}: this
};
// animation with some options set
el.setWidth(100, opt);
 * </code></pre>
 * <p>The Element animation object being used for the animation will be set on the options
 * object as "anim", which allows you to stop or manipulate the animation. Here is an example:</p>
 * <pre><code>
// using the "anim" property to get the Anim object
if(opt.anim.isAnimated()){
    opt.anim.stop();
}
 * </code></pre>
 * <p>Also see the <tt>{@link #animate}</tt> method for another animation technique.</p>
 * <p><b> Composite (Collections of) Elements</b></p>
 * <p>For working with collections of Elements, see {@link Ext.CompositeElement}</p>
 * @constructor Create a new Element directly.
 * @param {String/HTMLElement} element
 * @param {Boolean} forceNew (optional) By default the constructor checks to see if there is already an instance of this element in the cache and if there is it returns the same instance. This will skip that check (useful for extending this class).
 */
 (function() {
    var DOC = document,
        EC = Ext.cache;

    Ext.Element = Ext.core.Element = function(element, forceNew) {
        var dom = typeof element == "string" ? DOC.getElementById(element) : element,
        id;

        if (!dom) {
            return null;
        }

        id = dom.id;

        if (!forceNew && id && EC[id]) {
            // element object already exists
            return EC[id].el;
        }

        /**
     * The DOM element
     * @type HTMLElement
     */
        this.dom = dom;

        /**
     * The DOM element ID
     * @type String
     */
        this.id = id || Ext.id(dom);
    };

    var DH = Ext.core.DomHelper,
    El = Ext.core.Element;


    El.prototype = {
        /**
     * Sets the passed attributes as attributes of this element (a style attribute can be a string, object or function)
     * @param {Object} o The object with the attributes
     * @param {Boolean} useSet (optional) false to override the default setAttribute to use expandos.
     * @return {Ext.core.Element} this
     */
        set: function(o, useSet) {
            var el = this.dom,
                attr,
                val;
            useSet = (useSet !== false) && !!el.setAttribute;

            for (attr in o) {
                if (o.hasOwnProperty(attr)) {
                    val = o[attr];
                    if (attr == 'style') {
                        DH.applyStyles(el, val);
                    } else if (attr == 'cls') {
                        el.className = val;
                    } else if (useSet) {
                        el.setAttribute(attr, val);
                    } else {
                        el[attr] = val;
                    }
                }
            }
            return this;
        },

        //  Mouse events
        /**
     * @event click
     * Fires when a mouse click is detected within the element.
     * @param {Ext.EventObject} e The {@link Ext.EventObject} encapsulating the DOM event.
     * @param {HtmlElement} t The target of the event.
     * @param {Object} o The options configuration passed to the {@link #addListener} call.
     */
        /**
     * @event contextmenu
     * Fires when a right click is detected within the element.
     * @param {Ext.EventObject} e The {@link Ext.EventObject} encapsulating the DOM event.
     * @param {HtmlElement} t The target of the event.
     * @param {Object} o The options configuration passed to the {@link #addListener} call.
     */
        /**
     * @event dblclick
     * Fires when a mouse double click is detected within the element.
     * @param {Ext.EventObject} e The {@link Ext.EventObject} encapsulating the DOM event.
     * @param {HtmlElement} t The target of the event.
     * @param {Object} o The options configuration passed to the {@link #addListener} call.
     */
        /**
     * @event mousedown
     * Fires when a mousedown is detected within the element.
     * @param {Ext.EventObject} e The {@link Ext.EventObject} encapsulating the DOM event.
     * @param {HtmlElement} t The target of the event.
     * @param {Object} o The options configuration passed to the {@link #addListener} call.
     */
        /**
     * @event mouseup
     * Fires when a mouseup is detected within the element.
     * @param {Ext.EventObject} e The {@link Ext.EventObject} encapsulating the DOM event.
     * @param {HtmlElement} t The target of the event.
     * @param {Object} o The options configuration passed to the {@link #addListener} call.
     */
        /**
     * @event mouseover
     * Fires when a mouseover is detected within the element.
     * @param {Ext.EventObject} e The {@link Ext.EventObject} encapsulating the DOM event.
     * @param {HtmlElement} t The target of the event.
     * @param {Object} o The options configuration passed to the {@link #addListener} call.
     */
        /**
     * @event mousemove
     * Fires when a mousemove is detected with the element.
     * @param {Ext.EventObject} e The {@link Ext.EventObject} encapsulating the DOM event.
     * @param {HtmlElement} t The target of the event.
     * @param {Object} o The options configuration passed to the {@link #addListener} call.
     */
        /**
     * @event mouseout
     * Fires when a mouseout is detected with the element.
     * @param {Ext.EventObject} e The {@link Ext.EventObject} encapsulating the DOM event.
     * @param {HtmlElement} t The target of the event.
     * @param {Object} o The options configuration passed to the {@link #addListener} call.
     */
        /**
     * @event mouseenter
     * Fires when the mouse enters the element.
     * @param {Ext.EventObject} e The {@link Ext.EventObject} encapsulating the DOM event.
     * @param {HtmlElement} t The target of the event.
     * @param {Object} o The options configuration passed to the {@link #addListener} call.
     */
        /**
     * @event mouseleave
     * Fires when the mouse leaves the element.
     * @param {Ext.EventObject} e The {@link Ext.EventObject} encapsulating the DOM event.
     * @param {HtmlElement} t The target of the event.
     * @param {Object} o The options configuration passed to the {@link #addListener} call.
     */

        //  Keyboard events
        /**
     * @event keypress
     * Fires when a keypress is detected within the element.
     * @param {Ext.EventObject} e The {@link Ext.EventObject} encapsulating the DOM event.
     * @param {HtmlElement} t The target of the event.
     * @param {Object} o The options configuration passed to the {@link #addListener} call.
     */
        /**
     * @event keydown
     * Fires when a keydown is detected within the element.
     * @param {Ext.EventObject} e The {@link Ext.EventObject} encapsulating the DOM event.
     * @param {HtmlElement} t The target of the event.
     * @param {Object} o The options configuration passed to the {@link #addListener} call.
     */
        /**
     * @event keyup
     * Fires when a keyup is detected within the element.
     * @param {Ext.EventObject} e The {@link Ext.EventObject} encapsulating the DOM event.
     * @param {HtmlElement} t The target of the event.
     * @param {Object} o The options configuration passed to the {@link #addListener} call.
     */


        //  HTML frame/object events
        /**
     * @event load
     * Fires when the user agent finishes loading all content within the element. Only supported by window, frames, objects and images.
     * @param {Ext.EventObject} e The {@link Ext.EventObject} encapsulating the DOM event.
     * @param {HtmlElement} t The target of the event.
     * @param {Object} o The options configuration passed to the {@link #addListener} call.
     */
        /**
     * @event unload
     * Fires when the user agent removes all content from a window or frame. For elements, it fires when the target element or any of its content has been removed.
     * @param {Ext.EventObject} e The {@link Ext.EventObject} encapsulating the DOM event.
     * @param {HtmlElement} t The target of the event.
     * @param {Object} o The options configuration passed to the {@link #addListener} call.
     */
        /**
     * @event abort
     * Fires when an object/image is stopped from loading before completely loaded.
     * @param {Ext.EventObject} e The {@link Ext.EventObject} encapsulating the DOM event.
     * @param {HtmlElement} t The target of the event.
     * @param {Object} o The options configuration passed to the {@link #addListener} call.
     */
        /**
     * @event error
     * Fires when an object/image/frame cannot be loaded properly.
     * @param {Ext.EventObject} e The {@link Ext.EventObject} encapsulating the DOM event.
     * @param {HtmlElement} t The target of the event.
     * @param {Object} o The options configuration passed to the {@link #addListener} call.
     */
        /**
     * @event resize
     * Fires when a document view is resized.
     * @param {Ext.EventObject} e The {@link Ext.EventObject} encapsulating the DOM event.
     * @param {HtmlElement} t The target of the event.
     * @param {Object} o The options configuration passed to the {@link #addListener} call.
     */
        /**
     * @event scroll
     * Fires when a document view is scrolled.
     * @param {Ext.EventObject} e The {@link Ext.EventObject} encapsulating the DOM event.
     * @param {HtmlElement} t The target of the event.
     * @param {Object} o The options configuration passed to the {@link #addListener} call.
     */

        //  Form events
        /**
     * @event select
     * Fires when a user selects some text in a text field, including input and textarea.
     * @param {Ext.EventObject} e The {@link Ext.EventObject} encapsulating the DOM event.
     * @param {HtmlElement} t The target of the event.
     * @param {Object} o The options configuration passed to the {@link #addListener} call.
     */
        /**
     * @event change
     * Fires when a control loses the input focus and its value has been modified since gaining focus.
     * @param {Ext.EventObject} e The {@link Ext.EventObject} encapsulating the DOM event.
     * @param {HtmlElement} t The target of the event.
     * @param {Object} o The options configuration passed to the {@link #addListener} call.
     */
        /**
     * @event submit
     * Fires when a form is submitted.
     * @param {Ext.EventObject} e The {@link Ext.EventObject} encapsulating the DOM event.
     * @param {HtmlElement} t The target of the event.
     * @param {Object} o The options configuration passed to the {@link #addListener} call.
     */
        /**
     * @event reset
     * Fires when a form is reset.
     * @param {Ext.EventObject} e The {@link Ext.EventObject} encapsulating the DOM event.
     * @param {HtmlElement} t The target of the event.
     * @param {Object} o The options configuration passed to the {@link #addListener} call.
     */
        /**
     * @event focus
     * Fires when an element receives focus either via the pointing device or by tab navigation.
     * @param {Ext.EventObject} e The {@link Ext.EventObject} encapsulating the DOM event.
     * @param {HtmlElement} t The target of the event.
     * @param {Object} o The options configuration passed to the {@link #addListener} call.
     */
        /**
     * @event blur
     * Fires when an element loses focus either via the pointing device or by tabbing navigation.
     * @param {Ext.EventObject} e The {@link Ext.EventObject} encapsulating the DOM event.
     * @param {HtmlElement} t The target of the event.
     * @param {Object} o The options configuration passed to the {@link #addListener} call.
     */

        //  User Interface events
        /**
     * @event DOMFocusIn
     * Where supported. Similar to HTML focus event, but can be applied to any focusable element.
     * @param {Ext.EventObject} e The {@link Ext.EventObject} encapsulating the DOM event.
     * @param {HtmlElement} t The target of the event.
     * @param {Object} o The options configuration passed to the {@link #addListener} call.
     */
        /**
     * @event DOMFocusOut
     * Where supported. Similar to HTML blur event, but can be applied to any focusable element.
     * @param {Ext.EventObject} e The {@link Ext.EventObject} encapsulating the DOM event.
     * @param {HtmlElement} t The target of the event.
     * @param {Object} o The options configuration passed to the {@link #addListener} call.
     */
        /**
     * @event DOMActivate
     * Where supported. Fires when an element is activated, for instance, through a mouse click or a keypress.
     * @param {Ext.EventObject} e The {@link Ext.EventObject} encapsulating the DOM event.
     * @param {HtmlElement} t The target of the event.
     * @param {Object} o The options configuration passed to the {@link #addListener} call.
     */

        //  DOM Mutation events
        /**
     * @event DOMSubtreeModified
     * Where supported. Fires when the subtree is modified.
     * @param {Ext.EventObject} e The {@link Ext.EventObject} encapsulating the DOM event.
     * @param {HtmlElement} t The target of the event.
     * @param {Object} o The options configuration passed to the {@link #addListener} call.
     */
        /**
     * @event DOMNodeInserted
     * Where supported. Fires when a node has been added as a child of another node.
     * @param {Ext.EventObject} e The {@link Ext.EventObject} encapsulating the DOM event.
     * @param {HtmlElement} t The target of the event.
     * @param {Object} o The options configuration passed to the {@link #addListener} call.
     */
        /**
     * @event DOMNodeRemoved
     * Where supported. Fires when a descendant node of the element is removed.
     * @param {Ext.EventObject} e The {@link Ext.EventObject} encapsulating the DOM event.
     * @param {HtmlElement} t The target of the event.
     * @param {Object} o The options configuration passed to the {@link #addListener} call.
     */
        /**
     * @event DOMNodeRemovedFromDocument
     * Where supported. Fires when a node is being removed from a document.
     * @param {Ext.EventObject} e The {@link Ext.EventObject} encapsulating the DOM event.
     * @param {HtmlElement} t The target of the event.
     * @param {Object} o The options configuration passed to the {@link #addListener} call.
     */
        /**
     * @event DOMNodeInsertedIntoDocument
     * Where supported. Fires when a node is being inserted into a document.
     * @param {Ext.EventObject} e The {@link Ext.EventObject} encapsulating the DOM event.
     * @param {HtmlElement} t The target of the event.
     * @param {Object} o The options configuration passed to the {@link #addListener} call.
     */
        /**
     * @event DOMAttrModified
     * Where supported. Fires when an attribute has been modified.
     * @param {Ext.EventObject} e The {@link Ext.EventObject} encapsulating the DOM event.
     * @param {HtmlElement} t The target of the event.
     * @param {Object} o The options configuration passed to the {@link #addListener} call.
     */
        /**
     * @event DOMCharacterDataModified
     * Where supported. Fires when the character data has been modified.
     * @param {Ext.EventObject} e The {@link Ext.EventObject} encapsulating the DOM event.
     * @param {HtmlElement} t The target of the event.
     * @param {Object} o The options configuration passed to the {@link #addListener} call.
     */

        /**
     * The default unit to append to CSS values where a unit isn't provided (defaults to px).
     * @type String
     */
        defaultUnit: "px",

        /**
     * Returns true if this element matches the passed simple selector (e.g. div.some-class or span:first-child)
     * @param {String} selector The simple selector to test
     * @return {Boolean} True if this element matches the selector, else false
     */
        is: function(simpleSelector) {
            return Ext.DomQuery.is(this.dom, simpleSelector);
        },

        /**
     * Tries to focus the element. Any exceptions are caught and ignored.
     * @param {Number} defer (optional) Milliseconds to defer the focus
     * @return {Ext.core.Element} this
     */
        focus: function(defer,
                        /* private */
                        dom) {
            var me = this;
            dom = dom || me.dom;
            try {
                if (Number(defer)) {
                    Ext.defer(me.focus, defer, null, [null, dom]);
                } else {
                    dom.focus();
                }
            } catch(e) {}
            return me;
        },

        /**
     * Tries to blur the element. Any exceptions are caught and ignored.
     * @return {Ext.core.Element} this
     */
        blur: function() {
            try {
                this.dom.blur();
            } catch(e) {}
            return this;
        },

        /**
     * Returns the value of the "value" attribute
     * @param {Boolean} asNumber true to parse the value as a number
     * @return {String/Number}
     */
        getValue: function(asNumber) {
            var val = this.dom.value;
            return asNumber ? parseInt(val, 10) : val;
        },

        /**
     * Appends an event handler to this element.  The shorthand version {@link #on} is equivalent.
     * @param {String} eventName The name of event to handle.
     * @param {Function} fn The handler function the event invokes. This function is passed
     * the following parameters:<ul>
     * <li><b>evt</b> : EventObject<div class="sub-desc">The {@link Ext.EventObject EventObject} describing the event.</div></li>
     * <li><b>el</b> : HtmlElement<div class="sub-desc">The DOM element which was the target of the event.
     * Note that this may be filtered by using the <tt>delegate</tt> option.</div></li>
     * <li><b>o</b> : Object<div class="sub-desc">The options object from the addListener call.</div></li>
     * </ul>
     * @param {Object} scope (optional) The scope (<code><b>this</b></code> reference) in which the handler function is executed.
     * <b>If omitted, defaults to this Element.</b>.
     * @param {Object} options (optional) An object containing handler configuration properties.
     * This may contain any of the following properties:<ul>
     * <li><b>scope</b> Object : <div class="sub-desc">The scope (<code><b>this</b></code> reference) in which the handler function is executed.
     * <b>If omitted, defaults to this Element.</b></div></li>
     * <li><b>delegate</b> String: <div class="sub-desc">A simple selector to filter the target or look for a descendant of the target. See below for additional details.</div></li>
     * <li><b>stopEvent</b> Boolean: <div class="sub-desc">True to stop the event. That is stop propagation, and prevent the default action.</div></li>
     * <li><b>preventDefault</b> Boolean: <div class="sub-desc">True to prevent the default action</div></li>
     * <li><b>stopPropagation</b> Boolean: <div class="sub-desc">True to prevent event propagation</div></li>
     * <li><b>normalized</b> Boolean: <div class="sub-desc">False to pass a browser event to the handler function instead of an Ext.EventObject</div></li>
     * <li><b>target</b> Ext.core.Element: <div class="sub-desc">Only call the handler if the event was fired on the target Element, <i>not</i> if the event was bubbled up from a child node.</div></li>
     * <li><b>delay</b> Number: <div class="sub-desc">The number of milliseconds to delay the invocation of the handler after the event fires.</div></li>
     * <li><b>single</b> Boolean: <div class="sub-desc">True to add a handler to handle just the next firing of the event, and then remove itself.</div></li>
     * <li><b>buffer</b> Number: <div class="sub-desc">Causes the handler to be scheduled to run in an {@link Ext.util.DelayedTask} delayed
     * by the specified number of milliseconds. If the event fires again within that time, the original
     * handler is <em>not</em> invoked, but the new handler is scheduled in its place.</div></li>
     * </ul><br>
     * <p>
     * <b>Combining Options</b><br>
     * In the following examples, the shorthand form {@link #on} is used rather than the more verbose
     * addListener.  The two are equivalent.  Using the options argument, it is possible to combine different
     * types of listeners:<br>
     * <br>
     * A delayed, one-time listener that auto stops the event and adds a custom argument (forumId) to the
     * options object. The options object is available as the third parameter in the handler function.<div style="margin: 5px 20px 20px;">
     * Code:<pre><code>
el.on('click', this.onClick, this, {
    single: true,
    delay: 100,
    stopEvent : true,
    forumId: 4
});</code></pre></p>
     * <p>
     * <b>Attaching multiple handlers in 1 call</b><br>
     * The method also allows for a single argument to be passed which is a config object containing properties
     * which specify multiple handlers.</p>
     * <p>
     * Code:<pre><code>
el.on({
    'click' : {
        fn: this.onClick,
        scope: this,
        delay: 100
    },
    'mouseover' : {
        fn: this.onMouseOver,
        scope: this
    },
    'mouseout' : {
        fn: this.onMouseOut,
        scope: this
    }
});</code></pre>
     * <p>
     * Or a shorthand syntax:<br>
     * Code:<pre><code></p>
el.on({
    'click' : this.onClick,
    'mouseover' : this.onMouseOver,
    'mouseout' : this.onMouseOut,
    scope: this
});
     * </code></pre></p>
     * <p><b>delegate</b></p>
     * <p>This is a configuration option that you can pass along when registering a handler for
     * an event to assist with event delegation. Event delegation is a technique that is used to
     * reduce memory consumption and prevent exposure to memory-leaks. By registering an event
     * for a container element as opposed to each element within a container. By setting this
     * configuration option to a simple selector, the target element will be filtered to look for
     * a descendant of the target.
     * For example:<pre><code>
// using this markup:
&lt;div id='elId'>
    &lt;p id='p1'>paragraph one&lt;/p>
    &lt;p id='p2' class='clickable'>paragraph two&lt;/p>
    &lt;p id='p3'>paragraph three&lt;/p>
&lt;/div>
// utilize event delegation to registering just one handler on the container element:
el = Ext.get('elId');
el.on(
    'click',
    function(e,t) {
        // handle click
        console.info(t.id); // 'p2'
    },
    this,
    {
        // filter the target element to be a descendant with the class 'clickable'
        delegate: '.clickable'
    }
);
     * </code></pre></p>
     * @return {Ext.core.Element} this
     */
        addListener: function(eventName, fn, scope, options) {
            Ext.EventManager.on(this.dom, eventName, fn, scope || this, options);
            return this;
        },

        /**
     * Removes an event handler from this element.  The shorthand version {@link #un} is equivalent.
     * <b>Note</b>: if a <i>scope</i> was explicitly specified when {@link #addListener adding} the
     * listener, the same scope must be specified here.
     * Example:
     * <pre><code>
el.removeListener('click', this.handlerFn);
// or
el.un('click', this.handlerFn);
</code></pre>
     * @param {String} eventName The name of the event from which to remove the handler.
     * @param {Function} fn The handler function to remove. <b>This must be a reference to the function passed into the {@link #addListener} call.</b>
     * @param {Object} scope If a scope (<b><code>this</code></b> reference) was specified when the listener was added,
     * then this must refer to the same object.
     * @return {Ext.core.Element} this
     */
        removeListener: function(eventName, fn, scope) {
            Ext.EventManager.un(this.dom, eventName, fn, scope || this);
            return this;
        },

        /**
     * Removes all previous added listeners from this element
     * @return {Ext.core.Element} this
     */
        removeAllListeners: function() {
            Ext.EventManager.removeAll(this.dom);
            return this;
        },

        /**
         * Recursively removes all previous added listeners from this element and its children
         * @return {Ext.core.Element} this
         */
        purgeAllListeners: function() {
            Ext.EventManager.purgeElement(this);
            return this;
        },

        /**
         * @private Test if size has a unit, otherwise appends the passed unit string, or the default for this Element.
         * @param size {Mixed} The size to set
         * @param units {String} The units to append to a numeric size value
         */
        addUnits: function(size, units) {

            // Most common case first: Size is set to a number
            if (Ext.isNumber(size)) {
                return size + (units || this.defaultUnit || 'px');
            }

            // Size set to a value which means "auto"
            if (size === "" || size == "auto" || size === undefined || size === null) {
                return size || '';
            }

            // Otherwise, warn if it's not a valid CSS measurement
            if (!unitPattern.test(size)) {
                //<debug>
                if (Ext.isDefined(Ext.global.console)) {
                    Ext.global.console.warn("Warning, size detected as NaN on Element.addUnits.");
                }
                //</debug>
                return size || '';
            }
            return size;
        },

        /**
         * Tests various css rules/browsers to determine if this element uses a border box
         * @return {Boolean}
         */
        isBorderBox: function() {
            return Ext.isBorderBox || noBoxAdjust[(this.dom.tagName || "").toLowerCase()];
        },

        /**
         * <p>Removes this element's dom reference.  Note that event and cache removal is handled at {@link Ext#removeNode Ext.removeNode}</p>
         */
        remove: function() {
            var me = this,
            dom = me.dom;

            if (dom) {
                delete me.dom;
                Ext.removeNode(dom);
            }
        },

        /**
         * Sets up event handlers to call the passed functions when the mouse is moved into and out of the Element.
         * @param {Function} overFn The function to call when the mouse enters the Element.
         * @param {Function} outFn The function to call when the mouse leaves the Element.
         * @param {Object} scope (optional) The scope (<code>this</code> reference) in which the functions are executed. Defaults to the Element's DOM element.
         * @param {Object} options (optional) Options for the listener. See {@link Ext.util.Observable#addListener the <tt>options</tt> parameter}.
         * @return {Ext.core.Element} this
         */
        hover: function(overFn, outFn, scope, options) {
            var me = this;
            me.on('mouseenter', overFn, scope || me.dom, options);
            me.on('mouseleave', outFn, scope || me.dom, options);
            return me;
        },

        /**
         * Returns true if this element is an ancestor of the passed element
         * @param {HTMLElement/String} el The element to check
         * @return {Boolean} True if this element is an ancestor of el, else false
         */
        contains: function(el) {
            return ! el ? false: Ext.core.Element.isAncestor(this.dom, el.dom ? el.dom: el);
        },

        /**
         * Returns the value of a namespaced attribute from the element's underlying DOM node.
         * @param {String} namespace The namespace in which to look for the attribute
         * @param {String} name The attribute name
         * @return {String} The attribute value
         * @deprecated
         */
        getAttributeNS: function(ns, name) {
            return this.getAttribute(name, ns);
        },

        /**
         * Returns the value of an attribute from the element's underlying DOM node.
         * @param {String} name The attribute name
         * @param {String} namespace (optional) The namespace in which to look for the attribute
         * @return {String} The attribute value
         * @method
         */
        getAttribute: (Ext.isIE && !(Ext.isIE9 && document.documentMode === 9)) ?
        function(name, ns) {
            var d = this.dom,
            type;
            if(ns) {
                type = typeof d[ns + ":" + name];
                if (type != 'undefined' && type != 'unknown') {
                    return d[ns + ":" + name] || null;
                }
                return null;
            }
            if (name === "for") {
                name = "htmlFor";
            }
            return d[name] || null;
        }: function(name, ns) {
            var d = this.dom;
            if (ns) {
               return d.getAttributeNS(ns, name) || d.getAttribute(ns + ":" + name);
            }
            return  d.getAttribute(name) || d[name] || null;
        },

        /**
         * Update the innerHTML of this element
         * @param {String} html The new HTML
         * @return {Ext.core.Element} this
         */
        update: function(html) {
            if (this.dom) {
                this.dom.innerHTML = html;
            }
            return this;
        }
    };

    var ep = El.prototype;

    El.addMethods = function(o) {
        Ext.apply(ep, o);
    };

    /**
     * Appends an event handler (shorthand for {@link #addListener}).
     * @param {String} eventName The name of event to handle.
     * @param {Function} fn The handler function the event invokes.
     * @param {Object} scope (optional) The scope (<code>this</code> reference) in which the handler function is executed.
     * @param {Object} options (optional) An object containing standard {@link #addListener} options
     * @member Ext.core.Element
     * @method on
     */
    ep.on = ep.addListener;

    /**
     * Removes an event handler from this element (see {@link #removeListener} for additional notes).
     * @param {String} eventName The name of the event from which to remove the handler.
     * @param {Function} fn The handler function to remove. <b>This must be a reference to the function passed into the {@link #addListener} call.</b>
     * @param {Object} scope If a scope (<b><code>this</code></b> reference) was specified when the listener was added,
     * then this must refer to the same object.
     * @return {Ext.core.Element} this
     * @member Ext.core.Element
     * @method un
     */
    ep.un = ep.removeListener;

    /**
     * Removes all previous added listeners from this element
     * @return {Ext.core.Element} this
     * @member Ext.core.Element
     * @method clearListeners
     */
    ep.clearListeners = ep.removeAllListeners;

    /**
     * Removes this element's dom reference.  Note that event and cache removal is handled at {@link Ext#removeNode Ext.removeNode}.
     * Alias to {@link #remove}.
     * @member Ext.core.Element
     * @method destroy
     */
    ep.destroy = ep.remove;

    /**
     * true to automatically adjust width and height settings for box-model issues (default to true)
     */
    ep.autoBoxAdjust = true;

    // private
    var unitPattern = /\d+(px|em|%|en|ex|pt|in|cm|mm|pc)$/i,
    docEl;

    /**
     * Retrieves Ext.core.Element objects.
     * <p><b>This method does not retrieve {@link Ext.Component Component}s.</b> This method
     * retrieves Ext.core.Element objects which encapsulate DOM elements. To retrieve a Component by
     * its ID, use {@link Ext.ComponentManager#get}.</p>
     * <p>Uses simple caching to consistently return the same object. Automatically fixes if an
     * object was recreated with the same id via AJAX or DOM.</p>
     * @param {Mixed} el The id of the node, a DOM Node or an existing Element.
     * @return {Element} The Element object (or null if no matching element was found)
     * @static
     * @member Ext.core.Element
     * @method get
     */
    El.get = function(el) {
        var ex,
        elm,
        id;
        if (!el) {
            return null;
        }
        if (typeof el == "string") {
            // element id
            if (! (elm = DOC.getElementById(el))) {
                return null;
            }
            if (EC[el] && EC[el].el) {
                ex = EC[el].el;
                ex.dom = elm;
            } else {
                ex = El.addToCache(new El(elm));
            }
            return ex;
        } else if (el.tagName) {
            // dom element
            if (! (id = el.id)) {
                id = Ext.id(el);
            }
            if (EC[id] && EC[id].el) {
                ex = EC[id].el;
                ex.dom = el;
            } else {
                ex = El.addToCache(new El(el));
            }
            return ex;
        } else if (el instanceof El) {
            if (el != docEl) {
                // refresh dom element in case no longer valid,
                // catch case where it hasn't been appended
                // If an el instance is passed, don't pass to getElementById without some kind of id
                if (Ext.isIE && (el.id == undefined || el.id == '')) {
                    el.dom = el.dom;
                } else {
                    el.dom = DOC.getElementById(el.id) || el.dom;
                }
            }
            return el;
        } else if (el.isComposite) {
            return el;
        } else if (Ext.isArray(el)) {
            return El.select(el);
        } else if (el == DOC) {
            // create a bogus element object representing the document object
            if (!docEl) {
                var f = function() {};
                f.prototype = El.prototype;
                docEl = new f();
                docEl.dom = DOC;
            }
            return docEl;
        }
        return null;
    };

    El.addToCache = function(el, id) {
        if (el) {
            id = id || el.id;
            EC[id] = {
                el: el,
                data: {},
                events: {}
            };
        }
        return el;
    };

    // private method for getting and setting element data
    El.data = function(el, key, value) {
        el = El.get(el);
        if (!el) {
            return null;
        }
        var c = EC[el.id].data;
        if (arguments.length == 2) {
            return c[key];
        } else {
            return (c[key] = value);
        }
    };

    // private
    // Garbage collection - uncache elements/purge listeners on orphaned elements
    // so we don't hold a reference and cause the browser to retain them
    function garbageCollect() {
        if (!Ext.enableGarbageCollector) {
            clearInterval(El.collectorThreadId);
        } else {
            var eid,
            el,
            d,
            o;

            for (eid in EC) {
                if (!EC.hasOwnProperty(eid)) {
                    continue;
                }
                o = EC[eid];
                if (o.skipGarbageCollection) {
                    continue;
                }
                el = o.el;
                d = el.dom;
                // -------------------------------------------------------
                // Determining what is garbage:
                // -------------------------------------------------------
                // !d
                // dom node is null, definitely garbage
                // -------------------------------------------------------
                // !d.parentNode
                // no parentNode == direct orphan, definitely garbage
                // -------------------------------------------------------
                // !d.offsetParent && !document.getElementById(eid)
                // display none elements have no offsetParent so we will
                // also try to look it up by it's id. However, check
                // offsetParent first so we don't do unneeded lookups.
                // This enables collection of elements that are not orphans
                // directly, but somewhere up the line they have an orphan
                // parent.
                // -------------------------------------------------------
                if (!d || !d.parentNode || (!d.offsetParent && !DOC.getElementById(eid))) {
                    if (d && Ext.enableListenerCollection) {
                        Ext.EventManager.removeAll(d);
                    }
                    delete EC[eid];
                }
            }
            // Cleanup IE Object leaks
            if (Ext.isIE) {
                var t = {};
                for (eid in EC) {
                    if (!EC.hasOwnProperty(eid)) {
                        continue;
                    }
                    t[eid] = EC[eid];
                }
                EC = Ext.cache = t;
            }
        }
    }
    El.collectorThreadId = setInterval(garbageCollect, 30000);

    var flyFn = function() {};
    flyFn.prototype = El.prototype;

    // dom is optional
    El.Flyweight = function(dom) {
        this.dom = dom;
    };

    El.Flyweight.prototype = new flyFn();
    El.Flyweight.prototype.isFlyweight = true;
    El._flyweights = {};

    /**
     * <p>Gets the globally shared flyweight Element, with the passed node as the active element. Do not store a reference to this element -
     * the dom node can be overwritten by other code. Shorthand of {@link Ext.core.Element#fly}</p>
     * <p>Use this to make one-time references to DOM elements which are not going to be accessed again either by
     * application code, or by Ext's classes. If accessing an element which will be processed regularly, then {@link Ext#get Ext.get}
     * will be more appropriate to take advantage of the caching provided by the Ext.core.Element class.</p>
     * @param {String/HTMLElement} el The dom node or id
     * @param {String} named (optional) Allows for creation of named reusable flyweights to prevent conflicts
     * (e.g. internally Ext uses "_global")
     * @return {Element} The shared Element object (or null if no matching element was found)
     * @member Ext.core.Element
     * @method fly
     */
    El.fly = function(el, named) {
        var ret = null;
        named = named || '_global';
        el = Ext.getDom(el);
        if (el) {
            (El._flyweights[named] = El._flyweights[named] || new El.Flyweight()).dom = el;
            ret = El._flyweights[named];
        }
        return ret;
    };

    /**
     * Retrieves Ext.core.Element objects.
     * <p><b>This method does not retrieve {@link Ext.Component Component}s.</b> This method
     * retrieves Ext.core.Element objects which encapsulate DOM elements. To retrieve a Component by
     * its ID, use {@link Ext.ComponentManager#get}.</p>
     * <p>Uses simple caching to consistently return the same object. Automatically fixes if an
     * object was recreated with the same id via AJAX or DOM.</p>
     * Shorthand of {@link Ext.core.Element#get}
     * @param {Mixed} el The id of the node, a DOM Node or an existing Element.
     * @return {Element} The Element object (or null if no matching element was found)
     * @member Ext
     * @method get
     */
    Ext.get = El.get;

    /**
     * <p>Gets the globally shared flyweight Element, with the passed node as the active element. Do not store a reference to this element -
     * the dom node can be overwritten by other code. Shorthand of {@link Ext.core.Element#fly}</p>
     * <p>Use this to make one-time references to DOM elements which are not going to be accessed again either by
     * application code, or by Ext's classes. If accessing an element which will be processed regularly, then {@link Ext#get Ext.get}
     * will be more appropriate to take advantage of the caching provided by the Ext.core.Element class.</p>
     * @param {String/HTMLElement} el The dom node or id
     * @param {String} named (optional) Allows for creation of named reusable flyweights to prevent conflicts
     * (e.g. internally Ext uses "_global")
     * @return {Element} The shared Element object (or null if no matching element was found)
     * @member Ext
     * @method fly
     */
    Ext.fly = El.fly;

    // speedy lookup for elements never to box adjust
    var noBoxAdjust = Ext.isStrict ? {
        select: 1
    }: {
        input: 1,
        select: 1,
        textarea: 1
    };
    if (Ext.isIE || Ext.isGecko) {
        noBoxAdjust['button'] = 1;
    }
})();

/**
 * @class Ext.core.Element
 */
Ext.core.Element.addMethods({
    /**
     * Looks at this node and then at parent nodes for a match of the passed simple selector (e.g. div.some-class or span:first-child)
     * @param {String} selector The simple selector to test
     * @param {Number/Mixed} maxDepth (optional) The max depth to search as a number or element (defaults to 50 || document.body)
     * @param {Boolean} returnEl (optional) True to return a Ext.core.Element object instead of DOM node
     * @return {HTMLElement} The matching DOM node (or null if no match was found)
     */
    findParent : function(simpleSelector, maxDepth, returnEl) {
        var p = this.dom,
            b = document.body,
            depth = 0,
            stopEl;

        maxDepth = maxDepth || 50;
        if (isNaN(maxDepth)) {
            stopEl = Ext.getDom(maxDepth);
            maxDepth = Number.MAX_VALUE;
        }
        while (p && p.nodeType == 1 && depth < maxDepth && p != b && p != stopEl) {
            if (Ext.DomQuery.is(p, simpleSelector)) {
                return returnEl ? Ext.get(p) : p;
            }
            depth++;
            p = p.parentNode;
        }
        return null;
    },
    
    /**
     * Looks at parent nodes for a match of the passed simple selector (e.g. div.some-class or span:first-child)
     * @param {String} selector The simple selector to test
     * @param {Number/Mixed} maxDepth (optional) The max depth to
            search as a number or element (defaults to 10 || document.body)
     * @param {Boolean} returnEl (optional) True to return a Ext.core.Element object instead of DOM node
     * @return {HTMLElement} The matching DOM node (or null if no match was found)
     */
    findParentNode : function(simpleSelector, maxDepth, returnEl) {
        var p = Ext.fly(this.dom.parentNode, '_internal');
        return p ? p.findParent(simpleSelector, maxDepth, returnEl) : null;
    },

    /**
     * Walks up the dom looking for a parent node that matches the passed simple selector (e.g. div.some-class or span:first-child).
     * This is a shortcut for findParentNode() that always returns an Ext.core.Element.
     * @param {String} selector The simple selector to test
     * @param {Number/Mixed} maxDepth (optional) The max depth to
            search as a number or element (defaults to 10 || document.body)
     * @return {Ext.core.Element} The matching DOM node (or null if no match was found)
     */
    up : function(simpleSelector, maxDepth) {
        return this.findParentNode(simpleSelector, maxDepth, true);
    },

    /**
     * Creates a {@link Ext.CompositeElement} for child nodes based on the passed CSS selector (the selector should not contain an id).
     * @param {String} selector The CSS selector
     * @return {CompositeElement/CompositeElement} The composite element
     */
    select : function(selector) {
        return Ext.core.Element.select(selector, false,  this.dom);
    },

    /**
     * Selects child nodes based on the passed CSS selector (the selector should not contain an id).
     * @param {String} selector The CSS selector
     * @return {Array} An array of the matched nodes
     */
    query : function(selector) {
        return Ext.DomQuery.select(selector, this.dom);
    },

    /**
     * Selects a single child at any depth below this element based on the passed CSS selector (the selector should not contain an id).
     * @param {String} selector The CSS selector
     * @param {Boolean} returnDom (optional) True to return the DOM node instead of Ext.core.Element (defaults to false)
     * @return {HTMLElement/Ext.core.Element} The child Ext.core.Element (or DOM node if returnDom = true)
     */
    down : function(selector, returnDom) {
        var n = Ext.DomQuery.selectNode(selector, this.dom);
        return returnDom ? n : Ext.get(n);
    },

    /**
     * Selects a single *direct* child based on the passed CSS selector (the selector should not contain an id).
     * @param {String} selector The CSS selector
     * @param {Boolean} returnDom (optional) True to return the DOM node instead of Ext.core.Element (defaults to false)
     * @return {HTMLElement/Ext.core.Element} The child Ext.core.Element (or DOM node if returnDom = true)
     */
    child : function(selector, returnDom) {
        var node,
            me = this,
            id;
        id = Ext.get(me).id;
        // Escape . or :
        id = id.replace(/[\.:]/g, "\\$0");
        node = Ext.DomQuery.selectNode('#' + id + " > " + selector, me.dom);
        return returnDom ? node : Ext.get(node);
    },

     /**
     * Gets the parent node for this element, optionally chaining up trying to match a selector
     * @param {String} selector (optional) Find a parent node that matches the passed simple selector
     * @param {Boolean} returnDom (optional) True to return a raw dom node instead of an Ext.core.Element
     * @return {Ext.core.Element/HTMLElement} The parent node or null
     */
    parent : function(selector, returnDom) {
        return this.matchNode('parentNode', 'parentNode', selector, returnDom);
    },

     /**
     * Gets the next sibling, skipping text nodes
     * @param {String} selector (optional) Find the next sibling that matches the passed simple selector
     * @param {Boolean} returnDom (optional) True to return a raw dom node instead of an Ext.core.Element
     * @return {Ext.core.Element/HTMLElement} The next sibling or null
     */
    next : function(selector, returnDom) {
        return this.matchNode('nextSibling', 'nextSibling', selector, returnDom);
    },

    /**
     * Gets the previous sibling, skipping text nodes
     * @param {String} selector (optional) Find the previous sibling that matches the passed simple selector
     * @param {Boolean} returnDom (optional) True to return a raw dom node instead of an Ext.core.Element
     * @return {Ext.core.Element/HTMLElement} The previous sibling or null
     */
    prev : function(selector, returnDom) {
        return this.matchNode('previousSibling', 'previousSibling', selector, returnDom);
    },


    /**
     * Gets the first child, skipping text nodes
     * @param {String} selector (optional) Find the next sibling that matches the passed simple selector
     * @param {Boolean} returnDom (optional) True to return a raw dom node instead of an Ext.core.Element
     * @return {Ext.core.Element/HTMLElement} The first child or null
     */
    first : function(selector, returnDom) {
        return this.matchNode('nextSibling', 'firstChild', selector, returnDom);
    },

    /**
     * Gets the last child, skipping text nodes
     * @param {String} selector (optional) Find the previous sibling that matches the passed simple selector
     * @param {Boolean} returnDom (optional) True to return a raw dom node instead of an Ext.core.Element
     * @return {Ext.core.Element/HTMLElement} The last child or null
     */
    last : function(selector, returnDom) {
        return this.matchNode('previousSibling', 'lastChild', selector, returnDom);
    },

    matchNode : function(dir, start, selector, returnDom) {
        if (!this.dom) {
            return null;
        }
        
        var n = this.dom[start];
        while (n) {
            if (n.nodeType == 1 && (!selector || Ext.DomQuery.is(n, selector))) {
                return !returnDom ? Ext.get(n) : n;
            }
            n = n[dir];
        }
        return null;
    }
});

/**
 * @class Ext.core.Element
 */
Ext.core.Element.addMethods({
    /**
     * Appends the passed element(s) to this element
     * @param {String/HTMLElement/Array/Element/CompositeElement} el
     * @return {Ext.core.Element} this
     */
    appendChild : function(el) {
        return Ext.get(el).appendTo(this);
    },

    /**
     * Appends this element to the passed element
     * @param {Mixed} el The new parent element
     * @return {Ext.core.Element} this
     */
    appendTo : function(el) {
        Ext.getDom(el).appendChild(this.dom);
        return this;
    },

    /**
     * Inserts this element before the passed element in the DOM
     * @param {Mixed} el The element before which this element will be inserted
     * @return {Ext.core.Element} this
     */
    insertBefore : function(el) {
        el = Ext.getDom(el);
        el.parentNode.insertBefore(this.dom, el);
        return this;
    },

    /**
     * Inserts this element after the passed element in the DOM
     * @param {Mixed} el The element to insert after
     * @return {Ext.core.Element} this
     */
    insertAfter : function(el) {
        el = Ext.getDom(el);
        el.parentNode.insertBefore(this.dom, el.nextSibling);
        return this;
    },

    /**
     * Inserts (or creates) an element (or DomHelper config) as the first child of this element
     * @param {Mixed/Object} el The id or element to insert or a DomHelper config to create and insert
     * @return {Ext.core.Element} The new child
     */
    insertFirst : function(el, returnDom) {
        el = el || {};
        if (el.nodeType || el.dom || typeof el == 'string') { // element
            el = Ext.getDom(el);
            this.dom.insertBefore(el, this.dom.firstChild);
            return !returnDom ? Ext.get(el) : el;
        }
        else { // dh config
            return this.createChild(el, this.dom.firstChild, returnDom);
        }
    },

    /**
     * Inserts (or creates) the passed element (or DomHelper config) as a sibling of this element
     * @param {Mixed/Object/Array} el The id, element to insert or a DomHelper config to create and insert *or* an array of any of those.
     * @param {String} where (optional) 'before' or 'after' defaults to before
     * @param {Boolean} returnDom (optional) True to return the .;ll;l,raw DOM element instead of Ext.core.Element
     * @return {Ext.core.Element} The inserted Element. If an array is passed, the last inserted element is returned.
     */
    insertSibling: function(el, where, returnDom){
        var me = this, rt,
        isAfter = (where || 'before').toLowerCase() == 'after',
        insertEl;

        if(Ext.isArray(el)){
            insertEl = me;
            Ext.each(el, function(e) {
                rt = Ext.fly(insertEl, '_internal').insertSibling(e, where, returnDom);
                if(isAfter){
                    insertEl = rt;
                }
            });
            return rt;
        }

        el = el || {};

        if(el.nodeType || el.dom){
            rt = me.dom.parentNode.insertBefore(Ext.getDom(el), isAfter ? me.dom.nextSibling : me.dom);
            if (!returnDom) {
                rt = Ext.get(rt);
            }
        }else{
            if (isAfter && !me.dom.nextSibling) {
                rt = Ext.core.DomHelper.append(me.dom.parentNode, el, !returnDom);
            } else {
                rt = Ext.core.DomHelper[isAfter ? 'insertAfter' : 'insertBefore'](me.dom, el, !returnDom);
            }
        }
        return rt;
    },

    /**
     * Replaces the passed element with this element
     * @param {Mixed} el The element to replace
     * @return {Ext.core.Element} this
     */
    replace : function(el) {
        el = Ext.get(el);
        this.insertBefore(el);
        el.remove();
        return this;
    },
    
    /**
     * Replaces this element with the passed element
     * @param {Mixed/Object} el The new element or a DomHelper config of an element to create
     * @return {Ext.core.Element} this
     */
    replaceWith: function(el){
        var me = this;
            
        if(el.nodeType || el.dom || typeof el == 'string'){
            el = Ext.get(el);
            me.dom.parentNode.insertBefore(el, me.dom);
        }else{
            el = Ext.core.DomHelper.insertBefore(me.dom, el);
        }
        
        delete Ext.cache[me.id];
        Ext.removeNode(me.dom);      
        me.id = Ext.id(me.dom = el);
        Ext.core.Element.addToCache(me.isFlyweight ? new Ext.core.Element(me.dom) : me);     
        return me;
    },
    
    /**
     * Creates the passed DomHelper config and appends it to this element or optionally inserts it before the passed child element.
     * @param {Object} config DomHelper element config object.  If no tag is specified (e.g., {tag:'input'}) then a div will be
     * automatically generated with the specified attributes.
     * @param {HTMLElement} insertBefore (optional) a child element of this element
     * @param {Boolean} returnDom (optional) true to return the dom node instead of creating an Element
     * @return {Ext.core.Element} The new child element
     */
    createChild : function(config, insertBefore, returnDom) {
        config = config || {tag:'div'};
        if (insertBefore) {
            return Ext.core.DomHelper.insertBefore(insertBefore, config, returnDom !== true);
        }
        else {
            return Ext.core.DomHelper[!this.dom.firstChild ? 'insertFirst' : 'append'](this.dom, config,  returnDom !== true);
        }
    },

    /**
     * Creates and wraps this element with another element
     * @param {Object} config (optional) DomHelper element config object for the wrapper element or null for an empty div
     * @param {Boolean} returnDom (optional) True to return the raw DOM element instead of Ext.core.Element
     * @return {HTMLElement/Element} The newly created wrapper element
     */
    wrap : function(config, returnDom) {
        var newEl = Ext.core.DomHelper.insertBefore(this.dom, config || {tag: "div"}, !returnDom),
            d = newEl.dom || newEl;

        d.appendChild(this.dom);
        return newEl;
    },

    /**
     * Inserts an html fragment into this element
     * @param {String} where Where to insert the html in relation to this element - beforeBegin, afterBegin, beforeEnd, afterEnd.
     * @param {String} html The HTML fragment
     * @param {Boolean} returnEl (optional) True to return an Ext.core.Element (defaults to false)
     * @return {HTMLElement/Ext.core.Element} The inserted node (or nearest related if more than 1 inserted)
     */
    insertHtml : function(where, html, returnEl) {
        var el = Ext.core.DomHelper.insertHtml(where, this.dom, html);
        return returnEl ? Ext.get(el) : el;
    }
});

/**
 * @class Ext.core.Element
 */
(function(){
    Ext.core.Element.boxMarkup = '<div class="{0}-tl"><div class="{0}-tr"><div class="{0}-tc"></div></div></div><div class="{0}-ml"><div class="{0}-mr"><div class="{0}-mc"></div></div></div><div class="{0}-bl"><div class="{0}-br"><div class="{0}-bc"></div></div></div>';
    // local style camelizing for speed
    var supports = Ext.supports,
        view = document.defaultView,
        opacityRe = /alpha\(opacity=(.*)\)/i,
        trimRe = /^\s+|\s+$/g,
        spacesRe = /\s+/,
        wordsRe = /\w/g,
        adjustDirect2DTableRe = /table-row|table-.*-group/,
        INTERNAL = '_internal',
        PADDING = 'padding',
        MARGIN = 'margin',
        BORDER = 'border',
        LEFT = '-left',
        RIGHT = '-right',
        TOP = '-top',
        BOTTOM = '-bottom',
        WIDTH = '-width',
        MATH = Math,
        HIDDEN = 'hidden',
        ISCLIPPED = 'isClipped',
        OVERFLOW = 'overflow',
        OVERFLOWX = 'overflow-x',
        OVERFLOWY = 'overflow-y',
        ORIGINALCLIP = 'originalClip',
        // special markup used throughout Ext when box wrapping elements
        borders = {l: BORDER + LEFT + WIDTH, r: BORDER + RIGHT + WIDTH, t: BORDER + TOP + WIDTH, b: BORDER + BOTTOM + WIDTH},
        paddings = {l: PADDING + LEFT, r: PADDING + RIGHT, t: PADDING + TOP, b: PADDING + BOTTOM},
        margins = {l: MARGIN + LEFT, r: MARGIN + RIGHT, t: MARGIN + TOP, b: MARGIN + BOTTOM},
        data = Ext.core.Element.data;

    Ext.override(Ext.core.Element, {
        
        /**
         * TODO: Look at this
         */
        // private  ==> used by Fx
        adjustWidth : function(width) {
            var me = this,
                isNum = (typeof width == 'number');
                
            if(isNum && me.autoBoxAdjust && !me.isBorderBox()){
               width -= (me.getBorderWidth("lr") + me.getPadding("lr"));
            }
            return (isNum && width < 0) ? 0 : width;
        },

        // private   ==> used by Fx
        adjustHeight : function(height) {
            var me = this,
                isNum = (typeof height == "number");
                
            if(isNum && me.autoBoxAdjust && !me.isBorderBox()){
               height -= (me.getBorderWidth("tb") + me.getPadding("tb"));
            }
            return (isNum && height < 0) ? 0 : height;
        },


        /**
         * Adds one or more CSS classes to the element. Duplicate classes are automatically filtered out.
         * @param {String/Array} className The CSS classes to add separated by space, or an array of classes
         * @return {Ext.core.Element} this
         */
        addCls : function(className){
            var me = this,
                cls = [],
                space = ((me.dom.className.replace(trimRe, '') == '') ? "" : " "),
                i, len, v;
            if (className === undefined) {
                return me;
            }
            // Separate case is for speed
            if (Object.prototype.toString.call(className) !== '[object Array]') {
                if (typeof className === 'string') {
                    className = className.replace(trimRe, '').split(spacesRe);
                    if (className.length === 1) {
                        className = className[0];
                        if (!me.hasCls(className)) {
                            me.dom.className += space + className;
                        }
                    } else {
                        this.addCls(className);
                    }
                }
            } else {
                for (i = 0, len = className.length; i < len; i++) {
                    v = className[i];
                    if (typeof v == 'string' && (' ' + me.dom.className + ' ').indexOf(' ' + v + ' ') == -1) {
                        cls.push(v);
                    }
                }
                if (cls.length) {
                    me.dom.className += space + cls.join(" ");
                }
            }
            return me;
        },

        /**
         * Removes one or more CSS classes from the element.
         * @param {String/Array} className The CSS classes to remove separated by space, or an array of classes
         * @return {Ext.core.Element} this
         */
        removeCls : function(className){
            var me = this,
                i, idx, len, cls, elClasses;
            if (className === undefined) {
                return me;
            }
            if (Object.prototype.toString.call(className) !== '[object Array]') {
                className = className.replace(trimRe, '').split(spacesRe);
            }
            if (me.dom && me.dom.className) {
                elClasses = me.dom.className.replace(trimRe, '').split(spacesRe);
                for (i = 0, len = className.length; i < len; i++) {
                    cls = className[i];
                    if (typeof cls == 'string') {
                        cls = cls.replace(trimRe, '');
                        idx = Ext.Array.indexOf(elClasses, cls);
                        if (idx != -1) {
                            Ext.Array.erase(elClasses, idx, 1);
                        }
                    }
                }
                me.dom.className = elClasses.join(" ");
            }
            return me;
        },

        /**
         * Adds one or more CSS classes to this element and removes the same class(es) from all siblings.
         * @param {String/Array} className The CSS class to add, or an array of classes
         * @return {Ext.core.Element} this
         */
        radioCls : function(className){
            var cn = this.dom.parentNode.childNodes,
                v, i, len;
            className = Ext.isArray(className) ? className : [className];
            for (i = 0, len = cn.length; i < len; i++) {
                v = cn[i];
                if (v && v.nodeType == 1) {
                    Ext.fly(v, '_internal').removeCls(className);
                }
            }
            return this.addCls(className);
        },

        /**
         * Toggles the specified CSS class on this element (removes it if it already exists, otherwise adds it).
         * @param {String} className The CSS class to toggle
         * @return {Ext.core.Element} this
         * @method
         */
        toggleCls : Ext.supports.ClassList ?
            function(className) {
                this.dom.classList.toggle(Ext.String.trim(className));
                return this;
            } :
            function(className) {
                return this.hasCls(className) ? this.removeCls(className) : this.addCls(className);
            },

        /**
         * Checks if the specified CSS class exists on this element's DOM node.
         * @param {String} className The CSS class to check for
         * @return {Boolean} True if the class exists, else false
         * @method
         */
        hasCls : Ext.supports.ClassList ?
            function(className) {
                if (!className) {
                    return false;
                }
                className = className.split(spacesRe);
                var ln = className.length,
                    i = 0;
                for (; i < ln; i++) {
                    if (className[i] && this.dom.classList.contains(className[i])) {
                        return true;
                    }
                }
                return false;
            } :
            function(className){
                return className && (' ' + this.dom.className + ' ').indexOf(' ' + className + ' ') != -1;
            },

        /**
         * Replaces a CSS class on the element with another.  If the old name does not exist, the new name will simply be added.
         * @param {String} oldClassName The CSS class to replace
         * @param {String} newClassName The replacement CSS class
         * @return {Ext.core.Element} this
         */
        replaceCls : function(oldClassName, newClassName){
            return this.removeCls(oldClassName).addCls(newClassName);
        },

        isStyle : function(style, val) {
            return this.getStyle(style) == val;
        },

        /**
         * Normalizes currentStyle and computedStyle.
         * @param {String} property The style property whose value is returned.
         * @return {String} The current value of the style property for this element.
         * @method
         */
        getStyle : function(){
            return view && view.getComputedStyle ?
                function(prop){
                    var el = this.dom,
                        v, cs, out, display, cleaner;

                    if(el == document){
                        return null;
                    }
                    prop = Ext.core.Element.normalize(prop);
                    out = (v = el.style[prop]) ? v :
                           (cs = view.getComputedStyle(el, "")) ? cs[prop] : null;
                           
                    // Ignore cases when the margin is correctly reported as 0, the bug only shows
                    // numbers larger.
                    if(prop == 'marginRight' && out != '0px' && !supports.RightMargin){
                        cleaner = Ext.core.Element.getRightMarginFixCleaner(el);
                        display = this.getStyle('display');
                        el.style.display = 'inline-block';
                        out = view.getComputedStyle(el, '').marginRight;
                        el.style.display = display;
                        cleaner();
                    }
                    
                    if(prop == 'backgroundColor' && out == 'rgba(0, 0, 0, 0)' && !supports.TransparentColor){
                        out = 'transparent';
                    }
                    return out;
                } :
                function(prop){
                    var el = this.dom,
                        m, cs;

                    if (el == document) {
                        return null;
                    }
                    
                    if (prop == 'opacity') {
                        if (el.style.filter.match) {
                            m = el.style.filter.match(opacityRe);
                            if(m){
                                var fv = parseFloat(m[1]);
                                if(!isNaN(fv)){
                                    return fv ? fv / 100 : 0;
                                }
                            }
                        }
                        return 1;
                    }
                    prop = Ext.core.Element.normalize(prop);
                    return el.style[prop] || ((cs = el.currentStyle) ? cs[prop] : null);
                };
        }(),

        /**
         * Return the CSS color for the specified CSS attribute. rgb, 3 digit (like #fff) and valid values
         * are convert to standard 6 digit hex color.
         * @param {String} attr The css attribute
         * @param {String} defaultValue The default value to use when a valid color isn't found
         * @param {String} prefix (optional) defaults to #. Use an empty string when working with
         * color anims.
         */
        getColor : function(attr, defaultValue, prefix){
            var v = this.getStyle(attr),
                color = prefix || prefix === '' ? prefix : '#',
                h;

            if(!v || (/transparent|inherit/.test(v))) {
                return defaultValue;
            }
            if(/^r/.test(v)){
                Ext.each(v.slice(4, v.length -1).split(','), function(s){
                    h = parseInt(s, 10);
                    color += (h < 16 ? '0' : '') + h.toString(16);
                });
            }else{
                v = v.replace('#', '');
                color += v.length == 3 ? v.replace(/^(\w)(\w)(\w)$/, '$1$1$2$2$3$3') : v;
            }
            return(color.length > 5 ? color.toLowerCase() : defaultValue);
        },

        /**
         * Wrapper for setting style properties, also takes single object parameter of multiple styles.
         * @param {String/Object} property The style property to be set, or an object of multiple styles.
         * @param {String} value (optional) The value to apply to the given property, or null if an object was passed.
         * @return {Ext.core.Element} this
         */
        setStyle : function(prop, value){
            var me = this,
                tmp, style;

            if (!me.dom) {
                return me;
            }
            if (typeof prop === 'string') {
                tmp = {};
                tmp[prop] = value;
                prop = tmp;
            }
            for (style in prop) {
                if (prop.hasOwnProperty(style)) {
                    value = Ext.value(prop[style], '');
                    if (style == 'opacity') {
                        me.setOpacity(value);
                    }
                    else {
                        me.dom.style[Ext.core.Element.normalize(style)] = value;
                    }
                }
            }
            return me;
        },

        /**
         * Set the opacity of the element
         * @param {Float} opacity The new opacity. 0 = transparent, .5 = 50% visibile, 1 = fully visible, etc
         * @param {Boolean/Object} animate (optional) a standard Element animation config object or <tt>true</tt> for
         * the default animation (<tt>{duration: .35, easing: 'easeIn'}</tt>)
         * @return {Ext.core.Element} this
         */
        setOpacity: function(opacity, animate) {
            var me = this,
                dom = me.dom,
                val,
                style;

            if (!me.dom) {
                return me;
            }

            style = me.dom.style;

            if (!animate || !me.anim) {
                if (!Ext.supports.Opacity) {
                    opacity = opacity < 1 ? 'alpha(opacity=' + opacity * 100 + ')': '';
                    val = style.filter.replace(opacityRe, '').replace(trimRe, '');

                    style.zoom = 1;
                    style.filter = val + (val.length > 0 ? ' ': '') + opacity;
                }
                else {
                    style.opacity = opacity;
                }
            }
            else {
                if (!Ext.isObject(animate)) {
                    animate = {
                        duration: 350,
                        easing: 'ease-in'
                    };
                }
                me.animate(Ext.applyIf({
                    to: {
                        opacity: opacity
                    }
                },
                animate));
            }
            return me;
        },


        /**
         * Clears any opacity settings from this element. Required in some cases for IE.
         * @return {Ext.core.Element} this
         */
        clearOpacity : function(){
            var style = this.dom.style;
            if(!Ext.supports.Opacity){
                if(!Ext.isEmpty(style.filter)){
                    style.filter = style.filter.replace(opacityRe, '').replace(trimRe, '');
                }
            }else{
                style.opacity = style['-moz-opacity'] = style['-khtml-opacity'] = '';
            }
            return this;
        },
        
        /**
         * @private
         * Returns 1 if the browser returns the subpixel dimension rounded to the lowest pixel.
         * @return {Number} 0 or 1 
         */
        adjustDirect2DDimension: function(dimension) {
            var me = this,
                dom = me.dom,
                display = me.getStyle('display'),
                inlineDisplay = dom.style['display'],
                inlinePosition = dom.style['position'],
                originIndex = dimension === 'width' ? 0 : 1,
                floating;
                
            if (display === 'inline') {
                dom.style['display'] = 'inline-block';
            }

            dom.style['position'] = display.match(adjustDirect2DTableRe) ? 'absolute' : 'static';

            // floating will contain digits that appears after the decimal point
            // if height or width are set to auto we fallback to msTransformOrigin calculation
            floating = (parseFloat(me.getStyle(dimension)) || parseFloat(dom.currentStyle.msTransformOrigin.split(' ')[originIndex]) * 2) % 1;
            
            dom.style['position'] = inlinePosition;
            
            if (display === 'inline') {
                dom.style['display'] = inlineDisplay;
            }

            return floating;
        },
        
        /**
         * Returns the offset height of the element
         * @param {Boolean} contentHeight (optional) true to get the height minus borders and padding
         * @return {Number} The element's height
         */
        getHeight: function(contentHeight, preciseHeight) {
            var me = this,
                dom = me.dom,
                hidden = Ext.isIE && me.isStyle('display', 'none'),
                height, overflow, style, floating;

            // IE Quirks mode acts more like a max-size measurement unless overflow is hidden during measurement.
            // We will put the overflow back to it's original value when we are done measuring.
            if (Ext.isIEQuirks) {
                style = dom.style;
                overflow = style.overflow;
                me.setStyle({ overflow: 'hidden'});
            }

            height = dom.offsetHeight;

            height = MATH.max(height, hidden ? 0 : dom.clientHeight) || 0;

            // IE9 Direct2D dimension rounding bug
            if (!hidden && Ext.supports.Direct2DBug) {
                floating = me.adjustDirect2DDimension('height');
                if (preciseHeight) {
                    height += floating;
                }
                else if (floating > 0 && floating < 0.5) {
                    height++;
                }
            }

            if (contentHeight) {
                height -= (me.getBorderWidth("tb") + me.getPadding("tb"));
            }

            if (Ext.isIEQuirks) {
                me.setStyle({ overflow: overflow});
            }

            if (height < 0) {
                height = 0;
            }
            return height;
        },
                
        /**
         * Returns the offset width of the element
         * @param {Boolean} contentWidth (optional) true to get the width minus borders and padding
         * @return {Number} The element's width
         */
        getWidth: function(contentWidth, preciseWidth) {
            var me = this,
                dom = me.dom,
                hidden = Ext.isIE && me.isStyle('display', 'none'),
                rect, width, overflow, style, floating, parentPosition;

            // IE Quirks mode acts more like a max-size measurement unless overflow is hidden during measurement.
            // We will put the overflow back to it's original value when we are done measuring.
            if (Ext.isIEQuirks) {
                style = dom.style;
                overflow = style.overflow;
                me.setStyle({overflow: 'hidden'});
            }
            
            // Fix Opera 10.5x width calculation issues 
            if (Ext.isOpera10_5) {
                if (dom.parentNode.currentStyle.position === 'relative') {
                    parentPosition = dom.parentNode.style.position;
                    dom.parentNode.style.position = 'static';
                    width = dom.offsetWidth;
                    dom.parentNode.style.position = parentPosition;
                }
                width = Math.max(width || 0, dom.offsetWidth);
            
            // Gecko will in some cases report an offsetWidth that is actually less than the width of the
            // text contents, because it measures fonts with sub-pixel precision but rounds the calculated
            // value down. Using getBoundingClientRect instead of offsetWidth allows us to get the precise
            // subpixel measurements so we can force them to always be rounded up. See
            // https://bugzilla.mozilla.org/show_bug.cgi?id=458617
            } else if (Ext.supports.BoundingClientRect) {
                rect = dom.getBoundingClientRect();
                width = rect.right - rect.left;
                width = preciseWidth ? width : Math.ceil(width);
            } else {
                width = dom.offsetWidth;
            }

            width = MATH.max(width, hidden ? 0 : dom.clientWidth) || 0;

            // IE9 Direct2D dimension rounding bug
            if (!hidden && Ext.supports.Direct2DBug) {
                floating = me.adjustDirect2DDimension('width');
                if (preciseWidth) {
                    width += floating;
                }
                else if (floating > 0 && floating < 0.5) {
                    width++;
                }
            }
            
            if (contentWidth) {
                width -= (me.getBorderWidth("lr") + me.getPadding("lr"));
            }
            
            if (Ext.isIEQuirks) {
                me.setStyle({ overflow: overflow});
            }

            if (width < 0) {
                width = 0;
            }
            return width;
        },

        /**
         * Set the width of this Element.
         * @param {Mixed} width The new width. This may be one of:<div class="mdetail-params"><ul>
         * <li>A Number specifying the new width in this Element's {@link #defaultUnit}s (by default, pixels).</li>
         * <li>A String used to set the CSS width style. Animation may <b>not</b> be used.
         * </ul></div>
         * @param {Boolean/Object} animate (optional) true for the default animation or a standard Element animation config object
         * @return {Ext.core.Element} this
         */
        setWidth : function(width, animate){
            var me = this;
            width = me.adjustWidth(width);
            if (!animate || !me.anim) {
                me.dom.style.width = me.addUnits(width);
            }
            else {
                if (!Ext.isObject(animate)) {
                    animate = {};
                }
                me.animate(Ext.applyIf({
                    to: {
                        width: width
                    }
                }, animate));
            }
            return me;
        },

        /**
         * Set the height of this Element.
         * <pre><code>
// change the height to 200px and animate with default configuration
Ext.fly('elementId').setHeight(200, true);

// change the height to 150px and animate with a custom configuration
Ext.fly('elId').setHeight(150, {
    duration : .5, // animation will have a duration of .5 seconds
    // will change the content to "finished"
    callback: function(){ this.{@link #update}("finished"); }
});
         * </code></pre>
         * @param {Mixed} height The new height. This may be one of:<div class="mdetail-params"><ul>
         * <li>A Number specifying the new height in this Element's {@link #defaultUnit}s (by default, pixels.)</li>
         * <li>A String used to set the CSS height style. Animation may <b>not</b> be used.</li>
         * </ul></div>
         * @param {Boolean/Object} animate (optional) true for the default animation or a standard Element animation config object
         * @return {Ext.core.Element} this
         */
         setHeight : function(height, animate){
            var me = this;
            height = me.adjustHeight(height);
            if (!animate || !me.anim) {
                me.dom.style.height = me.addUnits(height);
            }
            else {
                if (!Ext.isObject(animate)) {
                    animate = {};
                }
                me.animate(Ext.applyIf({
                    to: {
                        height: height
                    }
                }, animate));
            }
            return me;
        },

        /**
         * Gets the width of the border(s) for the specified side(s)
         * @param {String} side Can be t, l, r, b or any combination of those to add multiple values. For example,
         * passing <tt>'lr'</tt> would get the border <b><u>l</u></b>eft width + the border <b><u>r</u></b>ight width.
         * @return {Number} The width of the sides passed added together
         */
        getBorderWidth : function(side){
            return this.addStyles(side, borders);
        },

        /**
         * Gets the width of the padding(s) for the specified side(s)
         * @param {String} side Can be t, l, r, b or any combination of those to add multiple values. For example,
         * passing <tt>'lr'</tt> would get the padding <b><u>l</u></b>eft + the padding <b><u>r</u></b>ight.
         * @return {Number} The padding of the sides passed added together
         */
        getPadding : function(side){
            return this.addStyles(side, paddings);
        },

        /**
         *  Store the current overflow setting and clip overflow on the element - use <tt>{@link #unclip}</tt> to remove
         * @return {Ext.core.Element} this
         */
        clip : function(){
            var me = this,
                dom = me.dom;

            if(!data(dom, ISCLIPPED)){
                data(dom, ISCLIPPED, true);
                data(dom, ORIGINALCLIP, {
                    o: me.getStyle(OVERFLOW),
                    x: me.getStyle(OVERFLOWX),
                    y: me.getStyle(OVERFLOWY)
                });
                me.setStyle(OVERFLOW, HIDDEN);
                me.setStyle(OVERFLOWX, HIDDEN);
                me.setStyle(OVERFLOWY, HIDDEN);
            }
            return me;
        },

        /**
         *  Return clipping (overflow) to original clipping before <tt>{@link #clip}</tt> was called
         * @return {Ext.core.Element} this
         */
        unclip : function(){
            var me = this,
                dom = me.dom,
                clip;

            if(data(dom, ISCLIPPED)){
                data(dom, ISCLIPPED, false);
                clip = data(dom, ORIGINALCLIP);
                if(o.o){
                    me.setStyle(OVERFLOW, o.o);
                }
                if(o.x){
                    me.setStyle(OVERFLOWX, o.x);
                }
                if(o.y){
                    me.setStyle(OVERFLOWY, o.y);
                }
            }
            return me;
        },

        // private
        addStyles : function(sides, styles){
            var totalSize = 0,
                sidesArr = sides.match(wordsRe),
                i = 0,
                len = sidesArr.length,
                side, size;
            for (; i < len; i++) {
                side = sidesArr[i];
                size = side && parseInt(this.getStyle(styles[side]), 10);
                if (size) {
                    totalSize += MATH.abs(size);
                }
            }
            return totalSize;
        },

        margins : margins,
        
        /**
         * More flexible version of {@link #setStyle} for setting style properties.
         * @param {String/Object/Function} styles A style specification string, e.g. "width:100px", or object in the form {width:"100px"}, or
         * a function which returns such a specification.
         * @return {Ext.core.Element} this
         */
        applyStyles : function(style){
            Ext.core.DomHelper.applyStyles(this.dom, style);
            return this;
        },

        /**
         * Returns an object with properties matching the styles requested.
         * For example, el.getStyles('color', 'font-size', 'width') might return
         * {'color': '#FFFFFF', 'font-size': '13px', 'width': '100px'}.
         * @param {String} style1 A style name
         * @param {String} style2 A style name
         * @param {String} etc.
         * @return {Object} The style object
         */
        getStyles : function(){
            var styles = {},
                len = arguments.length,
                i = 0, style;
                
            for(; i < len; ++i) {
                style = arguments[i];
                styles[style] = this.getStyle(style);
            }
            return styles;
        },

       /**
        * <p>Wraps the specified element with a special 9 element markup/CSS block that renders by default as
        * a gray container with a gradient background, rounded corners and a 4-way shadow.</p>
        * <p>This special markup is used throughout Ext when box wrapping elements ({@link Ext.button.Button},
        * {@link Ext.panel.Panel} when <tt>{@link Ext.panel.Panel#frame frame=true}</tt>, {@link Ext.window.Window}).  The markup
        * is of this form:</p>
        * <pre><code>
    Ext.core.Element.boxMarkup =
    &#39;&lt;div class="{0}-tl">&lt;div class="{0}-tr">&lt;div class="{0}-tc">&lt;/div>&lt;/div>&lt;/div>
     &lt;div class="{0}-ml">&lt;div class="{0}-mr">&lt;div class="{0}-mc">&lt;/div>&lt;/div>&lt;/div>
     &lt;div class="{0}-bl">&lt;div class="{0}-br">&lt;div class="{0}-bc">&lt;/div>&lt;/div>&lt;/div>&#39;;
        * </code></pre>
        * <p>Example usage:</p>
        * <pre><code>
    // Basic box wrap
    Ext.get("foo").boxWrap();

    // You can also add a custom class and use CSS inheritance rules to customize the box look.
    // 'x-box-blue' is a built-in alternative -- look at the related CSS definitions as an example
    // for how to create a custom box wrap style.
    Ext.get("foo").boxWrap().addCls("x-box-blue");
        * </code></pre>
        * @param {String} class (optional) A base CSS class to apply to the containing wrapper element
        * (defaults to <tt>'x-box'</tt>). Note that there are a number of CSS rules that are dependent on
        * this name to make the overall effect work, so if you supply an alternate base class, make sure you
        * also supply all of the necessary rules.
        * @return {Ext.core.Element} The outermost wrapping element of the created box structure.
        */
        boxWrap : function(cls){
            cls = cls || Ext.baseCSSPrefix + 'box';
            var el = Ext.get(this.insertHtml("beforeBegin", "<div class='" + cls + "'>" + Ext.String.format(Ext.core.Element.boxMarkup, cls) + "</div>"));
            Ext.DomQuery.selectNode('.' + cls + '-mc', el.dom).appendChild(this.dom);
            return el;
        },

        /**
         * Set the size of this Element. If animation is true, both width and height will be animated concurrently.
         * @param {Mixed} width The new width. This may be one of:<div class="mdetail-params"><ul>
         * <li>A Number specifying the new width in this Element's {@link #defaultUnit}s (by default, pixels).</li>
         * <li>A String used to set the CSS width style. Animation may <b>not</b> be used.
         * <li>A size object in the format <code>{width: widthValue, height: heightValue}</code>.</li>
         * </ul></div>
         * @param {Mixed} height The new height. This may be one of:<div class="mdetail-params"><ul>
         * <li>A Number specifying the new height in this Element's {@link #defaultUnit}s (by default, pixels).</li>
         * <li>A String used to set the CSS height style. Animation may <b>not</b> be used.</li>
         * </ul></div>
         * @param {Boolean/Object} animate (optional) true for the default animation or a standard Element animation config object
         * @return {Ext.core.Element} this
         */
        setSize : function(width, height, animate){
            var me = this;
            if (Ext.isObject(width)) { // in case of object from getSize()
                animate = height;
                height = width.height;
                width = width.width;
            }
            width = me.adjustWidth(width);
            height = me.adjustHeight(height);
            if(!animate || !me.anim){
                me.dom.style.width = me.addUnits(width);
                me.dom.style.height = me.addUnits(height);
            }
            else {
                if (animate === true) {
                    animate = {};
                }
                me.animate(Ext.applyIf({
                    to: {
                        width: width,
                        height: height
                    }
                }, animate));
            }
            return me;
        },

        /**
         * Returns either the offsetHeight or the height of this element based on CSS height adjusted by padding or borders
         * when needed to simulate offsetHeight when offsets aren't available. This may not work on display:none elements
         * if a height has not been set using CSS.
         * @return {Number}
         */
        getComputedHeight : function(){
            var me = this,
                h = Math.max(me.dom.offsetHeight, me.dom.clientHeight);
            if(!h){
                h = parseFloat(me.getStyle('height')) || 0;
                if(!me.isBorderBox()){
                    h += me.getFrameWidth('tb');
                }
            }
            return h;
        },

        /**
         * Returns either the offsetWidth or the width of this element based on CSS width adjusted by padding or borders
         * when needed to simulate offsetWidth when offsets aren't available. This may not work on display:none elements
         * if a width has not been set using CSS.
         * @return {Number}
         */
        getComputedWidth : function(){
            var me = this,
                w = Math.max(me.dom.offsetWidth, me.dom.clientWidth);
                
            if(!w){
                w = parseFloat(me.getStyle('width')) || 0;
                if(!me.isBorderBox()){
                    w += me.getFrameWidth('lr');
                }
            }
            return w;
        },

        /**
         * Returns the sum width of the padding and borders for the passed "sides". See getBorderWidth()
         for more information about the sides.
         * @param {String} sides
         * @return {Number}
         */
        getFrameWidth : function(sides, onlyContentBox){
            return onlyContentBox && this.isBorderBox() ? 0 : (this.getPadding(sides) + this.getBorderWidth(sides));
        },

        /**
         * Sets up event handlers to add and remove a css class when the mouse is over this element
         * @param {String} className
         * @return {Ext.core.Element} this
         */
        addClsOnOver : function(className){
            var dom = this.dom;
            this.hover(
                function(){
                    Ext.fly(dom, INTERNAL).addCls(className);
                },
                function(){
                    Ext.fly(dom, INTERNAL).removeCls(className);
                }
            );
            return this;
        },

        /**
         * Sets up event handlers to add and remove a css class when this element has the focus
         * @param {String} className
         * @return {Ext.core.Element} this
         */
        addClsOnFocus : function(className){
            var me = this,
                dom = me.dom;
            me.on("focus", function(){
                Ext.fly(dom, INTERNAL).addCls(className);
            });
            me.on("blur", function(){
                Ext.fly(dom, INTERNAL).removeCls(className);
            });
            return me;
        },

        /**
         * Sets up event handlers to add and remove a css class when the mouse is down and then up on this element (a click effect)
         * @param {String} className
         * @return {Ext.core.Element} this
         */
        addClsOnClick : function(className){
            var dom = this.dom;
            this.on("mousedown", function(){
                Ext.fly(dom, INTERNAL).addCls(className);
                var d = Ext.getDoc(),
                    fn = function(){
                        Ext.fly(dom, INTERNAL).removeCls(className);
                        d.removeListener("mouseup", fn);
                    };
                d.on("mouseup", fn);
            });
            return this;
        },

        /**
         * <p>Returns the dimensions of the element available to lay content out in.<p>
         * <p>If the element (or any ancestor element) has CSS style <code>display : none</code>, the dimensions will be zero.</p>
         * example:<pre><code>
        var vpSize = Ext.getBody().getViewSize();

        // all Windows created afterwards will have a default value of 90% height and 95% width
        Ext.Window.override({
            width: vpSize.width * 0.9,
            height: vpSize.height * 0.95
        });
        // To handle window resizing you would have to hook onto onWindowResize.
        * </code></pre>
        *
        * getViewSize utilizes clientHeight/clientWidth which excludes sizing of scrollbars.
        * To obtain the size including scrollbars, use getStyleSize
        *
        * Sizing of the document body is handled at the adapter level which handles special cases for IE and strict modes, etc.
        */

        getViewSize : function(){
            var me = this,
                dom = me.dom,
                isDoc = (dom == Ext.getDoc().dom || dom == Ext.getBody().dom),
                style, overflow, ret;

            // If the body, use static methods
            if (isDoc) {
                ret = {
                    width : Ext.core.Element.getViewWidth(),
                    height : Ext.core.Element.getViewHeight()
                };

            // Else use clientHeight/clientWidth
            }
            else {
                // IE 6 & IE Quirks mode acts more like a max-size measurement unless overflow is hidden during measurement.
                // We will put the overflow back to it's original value when we are done measuring.
                if (Ext.isIE6 || Ext.isIEQuirks) {
                    style = dom.style;
                    overflow = style.overflow;
                    me.setStyle({ overflow: 'hidden'});
                }
                ret = {
                    width : dom.clientWidth,
                    height : dom.clientHeight
                };
                if (Ext.isIE6 || Ext.isIEQuirks) {
                    me.setStyle({ overflow: overflow });
                }
            }
            return ret;
        },

        /**
        * <p>Returns the dimensions of the element available to lay content out in.<p>
        *
        * getStyleSize utilizes prefers style sizing if present, otherwise it chooses the larger of offsetHeight/clientHeight and offsetWidth/clientWidth.
        * To obtain the size excluding scrollbars, use getViewSize
        *
        * Sizing of the document body is handled at the adapter level which handles special cases for IE and strict modes, etc.
        */

        getStyleSize : function(){
            var me = this,
                doc = document,
                d = this.dom,
                isDoc = (d == doc || d == doc.body),
                s = d.style,
                w, h;

            // If the body, use static methods
            if (isDoc) {
                return {
                    width : Ext.core.Element.getViewWidth(),
                    height : Ext.core.Element.getViewHeight()
                };
            }
            // Use Styles if they are set
            if(s.width && s.width != 'auto'){
                w = parseFloat(s.width);
                if(me.isBorderBox()){
                   w -= me.getFrameWidth('lr');
                }
            }
            // Use Styles if they are set
            if(s.height && s.height != 'auto'){
                h = parseFloat(s.height);
                if(me.isBorderBox()){
                   h -= me.getFrameWidth('tb');
                }
            }
            // Use getWidth/getHeight if style not set.
            return {width: w || me.getWidth(true), height: h || me.getHeight(true)};
        },

        /**
         * Returns the size of the element.
         * @param {Boolean} contentSize (optional) true to get the width/size minus borders and padding
         * @return {Object} An object containing the element's size {width: (element width), height: (element height)}
         */
        getSize : function(contentSize){
            return {width: this.getWidth(contentSize), height: this.getHeight(contentSize)};
        },

        /**
         * Forces the browser to repaint this element
         * @return {Ext.core.Element} this
         */
        repaint : function(){
            var dom = this.dom;
            this.addCls(Ext.baseCSSPrefix + 'repaint');
            setTimeout(function(){
                Ext.fly(dom).removeCls(Ext.baseCSSPrefix + 'repaint');
            }, 1);
            return this;
        },

        /**
         * Disables text selection for this element (normalized across browsers)
         * @return {Ext.core.Element} this
         */
        unselectable : function(){
            var me = this;
            me.dom.unselectable = "on";

            me.swallowEvent("selectstart", true);
            me.applyStyles("-moz-user-select:none;-khtml-user-select:none;");
            me.addCls(Ext.baseCSSPrefix + 'unselectable');
            
            return me;
        },

        /**
         * Returns an object with properties top, left, right and bottom representing the margins of this element unless sides is passed,
         * then it returns the calculated width of the sides (see getPadding)
         * @param {String} sides (optional) Any combination of l, r, t, b to get the sum of those sides
         * @return {Object/Number}
         */
        getMargin : function(side){
            var me = this,
                hash = {t:"top", l:"left", r:"right", b: "bottom"},
                o = {},
                key;

            if (!side) {
                for (key in me.margins){
                    o[hash[key]] = parseFloat(me.getStyle(me.margins[key])) || 0;
                }
                return o;
            } else {
                return me.addStyles.call(me, side, me.margins);
            }
        }
    });
})();
/**
 * @class Ext.core.Element
 */
/**
 * Visibility mode constant for use with {@link #setVisibilityMode}. Use visibility to hide element
 * @static
 * @type Number
 */
Ext.core.Element.VISIBILITY = 1;
/**
 * Visibility mode constant for use with {@link #setVisibilityMode}. Use display to hide element
 * @static
 * @type Number
 */
Ext.core.Element.DISPLAY = 2;

/**
 * Visibility mode constant for use with {@link #setVisibilityMode}. Use offsets (x and y positioning offscreen)
 * to hide element.
 * @static
 * @type Number
 */
Ext.core.Element.OFFSETS = 3;


Ext.core.Element.ASCLASS = 4;

/**
 * Defaults to 'x-hide-nosize'
 * @static
 * @type String
 */
Ext.core.Element.visibilityCls = Ext.baseCSSPrefix + 'hide-nosize';

Ext.core.Element.addMethods(function(){
    var El = Ext.core.Element,
        OPACITY = "opacity",
        VISIBILITY = "visibility",
        DISPLAY = "display",
        HIDDEN = "hidden",
        OFFSETS = "offsets",
        ASCLASS = "asclass",
        NONE = "none",
        NOSIZE = 'nosize',
        ORIGINALDISPLAY = 'originalDisplay',
        VISMODE = 'visibilityMode',
        ISVISIBLE = 'isVisible',
        data = El.data,
        getDisplay = function(dom){
            var d = data(dom, ORIGINALDISPLAY);
            if(d === undefined){
                data(dom, ORIGINALDISPLAY, d = '');
            }
            return d;
        },
        getVisMode = function(dom){
            var m = data(dom, VISMODE);
            if(m === undefined){
                data(dom, VISMODE, m = 1);
            }
            return m;
        };

    return {
        /**
         * The element's default display mode  (defaults to "")
         * @type String
         */
        originalDisplay : "",
        visibilityMode : 1,

        /**
         * Sets the element's visibility mode. When setVisible() is called it
         * will use this to determine whether to set the visibility or the display property.
         * @param {Number} visMode Ext.core.Element.VISIBILITY or Ext.core.Element.DISPLAY
         * @return {Ext.core.Element} this
         */
        setVisibilityMode : function(visMode){
            data(this.dom, VISMODE, visMode);
            return this;
        },

        /**
         * Checks whether the element is currently visible using both visibility and display properties.
         * @return {Boolean} True if the element is currently visible, else false
         */
        isVisible : function() {
            var me = this,
                dom = me.dom,
                visible = data(dom, ISVISIBLE);

            if(typeof visible == 'boolean'){ //return the cached value if registered
                return visible;
            }
            //Determine the current state based on display states
            visible = !me.isStyle(VISIBILITY, HIDDEN) &&
                      !me.isStyle(DISPLAY, NONE) &&
                      !((getVisMode(dom) == El.ASCLASS) && me.hasCls(me.visibilityCls || El.visibilityCls));

            data(dom, ISVISIBLE, visible);
            return visible;
        },

        /**
         * Sets the visibility of the element (see details). If the visibilityMode is set to Element.DISPLAY, it will use
         * the display property to hide the element, otherwise it uses visibility. The default is to hide and show using the visibility property.
         * @param {Boolean} visible Whether the element is visible
         * @param {Boolean/Object} animate (optional) True for the default animation, or a standard Element animation config object
         * @return {Ext.core.Element} this
         */
        setVisible : function(visible, animate){
            var me = this, isDisplay, isVisibility, isOffsets, isNosize,
                dom = me.dom,
                visMode = getVisMode(dom);


            // hideMode string override
            if (typeof animate == 'string'){
                switch (animate) {
                    case DISPLAY:
                        visMode = El.DISPLAY;
                        break;
                    case VISIBILITY:
                        visMode = El.VISIBILITY;
                        break;
                    case OFFSETS:
                        visMode = El.OFFSETS;
                        break;
                    case NOSIZE:
                    case ASCLASS:
                        visMode = El.ASCLASS;
                        break;
                }
                me.setVisibilityMode(visMode);
                animate = false;
            }

            if (!animate || !me.anim) {
                if(visMode == El.ASCLASS ){

                    me[visible?'removeCls':'addCls'](me.visibilityCls || El.visibilityCls);

                } else if (visMode == El.DISPLAY){

                    return me.setDisplayed(visible);

                } else if (visMode == El.OFFSETS){

                    if (!visible){
                        // Remember position for restoring, if we are not already hidden by offsets.
                        if (!me.hideModeStyles) {
                            me.hideModeStyles = {
                                position: me.getStyle('position'),
                                top: me.getStyle('top'),
                                left: me.getStyle('left')
                            };
                        }
                        me.applyStyles({position: 'absolute', top: '-10000px', left: '-10000px'});
                    }

                    // Only "restore" as position if we have actually been hidden using offsets.
                    // Calling setVisible(true) on a positioned element should not reposition it.
                    else if (me.hideModeStyles) {
                        me.applyStyles(me.hideModeStyles || {position: '', top: '', left: ''});
                        delete me.hideModeStyles;
                    }

                }else{
                    me.fixDisplay();
                    // Show by clearing visibility style. Explicitly setting to "visible" overrides parent visibility setting.
                    dom.style.visibility = visible ? '' : HIDDEN;
                }
            }else{
                // closure for composites
                if(visible){
                    me.setOpacity(0.01);
                    me.setVisible(true);
                }
                if (!Ext.isObject(animate)) {
                    animate = {
                        duration: 350,
                        easing: 'ease-in'
                    };
                }
                me.animate(Ext.applyIf({
                    callback: function() {
                        visible || me.setVisible(false).setOpacity(1);
                    },
                    to: {
                        opacity: (visible) ? 1 : 0
                    }
                }, animate));
            }
            data(dom, ISVISIBLE, visible);  //set logical visibility state
            return me;
        },


        /**
         * @private
         * Determine if the Element has a relevant height and width available based
         * upon current logical visibility state
         */
        hasMetrics  : function(){
            var dom = this.dom;
            return this.isVisible() || (getVisMode(dom) == El.OFFSETS) || (getVisMode(dom) == El.VISIBILITY);
        },

        /**
         * Toggles the element's visibility or display, depending on visibility mode.
         * @param {Boolean/Object} animate (optional) True for the default animation, or a standard Element animation config object
         * @return {Ext.core.Element} this
         */
        toggle : function(animate){
            var me = this;
            me.setVisible(!me.isVisible(), me.anim(animate));
            return me;
        },

        /**
         * Sets the CSS display property. Uses originalDisplay if the specified value is a boolean true.
         * @param {Mixed} value Boolean value to display the element using its default display, or a string to set the display directly.
         * @return {Ext.core.Element} this
         */
        setDisplayed : function(value) {
            if(typeof value == "boolean"){
               value = value ? getDisplay(this.dom) : NONE;
            }
            this.setStyle(DISPLAY, value);
            return this;
        },

        // private
        fixDisplay : function(){
            var me = this;
            if (me.isStyle(DISPLAY, NONE)) {
                me.setStyle(VISIBILITY, HIDDEN);
                me.setStyle(DISPLAY, getDisplay(this.dom)); // first try reverting to default
                if (me.isStyle(DISPLAY, NONE)) { // if that fails, default to block
                    me.setStyle(DISPLAY, "block");
                }
            }
        },

        /**
         * Hide this element - Uses display mode to determine whether to use "display" or "visibility". See {@link #setVisible}.
         * @param {Boolean/Object} animate (optional) true for the default animation or a standard Element animation config object
         * @return {Ext.core.Element} this
         */
        hide : function(animate){
            // hideMode override
            if (typeof animate == 'string'){
                this.setVisible(false, animate);
                return this;
            }
            this.setVisible(false, this.anim(animate));
            return this;
        },

        /**
        * Show this element - Uses display mode to determine whether to use "display" or "visibility". See {@link #setVisible}.
        * @param {Boolean/Object} animate (optional) true for the default animation or a standard Element animation config object
         * @return {Ext.core.Element} this
         */
        show : function(animate){
            // hideMode override
            if (typeof animate == 'string'){
                this.setVisible(true, animate);
                return this;
            }
            this.setVisible(true, this.anim(animate));
            return this;
        }
    };
}());
/**
 * @class Ext.core.Element
 */
Ext.applyIf(Ext.core.Element.prototype, {
    // @private override base Ext.util.Animate mixin for animate for backwards compatibility
    animate: function(config) {
        var me = this;
        if (!me.id) {
            me = Ext.get(me.dom);
        }
        if (Ext.fx.Manager.hasFxBlock(me.id)) {
            return me;
        }
        Ext.fx.Manager.queueFx(Ext.create('Ext.fx.Anim', me.anim(config)));
        return this;
    },

    // @private override base Ext.util.Animate mixin for animate for backwards compatibility
    anim: function(config) {
        if (!Ext.isObject(config)) {
            return (config) ? {} : false;
        }

        var me = this,
            duration = config.duration || Ext.fx.Anim.prototype.duration,
            easing = config.easing || 'ease',
            animConfig;

        if (config.stopAnimation) {
            me.stopAnimation();
        }

        Ext.applyIf(config, Ext.fx.Manager.getFxDefaults(me.id));

        // Clear any 'paused' defaults.
        Ext.fx.Manager.setFxDefaults(me.id, {
            delay: 0
        });

        animConfig = {
            target: me,
            remove: config.remove,
            alternate: config.alternate || false,
            duration: duration,
            easing: easing,
            callback: config.callback,
            listeners: config.listeners,
            iterations: config.iterations || 1,
            scope: config.scope,
            block: config.block,
            concurrent: config.concurrent,
            delay: config.delay || 0,
            paused: true,
            keyframes: config.keyframes,
            from: config.from || {},
            to: Ext.apply({}, config)
        };
        Ext.apply(animConfig.to, config.to);

        // Anim API properties - backward compat
        delete animConfig.to.to;
        delete animConfig.to.from;
        delete animConfig.to.remove;
        delete animConfig.to.alternate;
        delete animConfig.to.keyframes;
        delete animConfig.to.iterations;
        delete animConfig.to.listeners;
        delete animConfig.to.target;
        delete animConfig.to.paused;
        delete animConfig.to.callback;
        delete animConfig.to.scope;
        delete animConfig.to.duration;
        delete animConfig.to.easing;
        delete animConfig.to.concurrent;
        delete animConfig.to.block;
        delete animConfig.to.stopAnimation;
        delete animConfig.to.delay;
        return animConfig;
    },

    /**
     * Slides the element into view.  An anchor point can be optionally passed to set the point of
     * origin for the slide effect.  This function automatically handles wrapping the element with
     * a fixed-size container if needed.  See the Fx class overview for valid anchor point options.
     * Usage:
     *<pre><code>
// default: slide the element in from the top
el.slideIn();

// custom: slide the element in from the right with a 2-second duration
el.slideIn('r', { duration: 2 });

// common config options shown with default values
el.slideIn('t', {
    easing: 'easeOut',
    duration: 500
});
</code></pre>
     * @param {String} anchor (optional) One of the valid Fx anchor positions (defaults to top: 't')
     * @param {Object} options (optional) Object literal with any of the Fx config options
     * @return {Ext.core.Element} The Element
     */
    slideIn: function(anchor, obj, slideOut) { 
        var me = this,
            elStyle = me.dom.style,
            beforeAnim, wrapAnim;

        anchor = anchor || "t";
        obj = obj || {};

        beforeAnim = function() {
            var animScope = this,
                listeners = obj.listeners,
                box, position, restoreSize, wrap, anim;

            if (!slideOut) {
                me.fixDisplay();
            }

            box = me.getBox();
            if ((anchor == 't' || anchor == 'b') && box.height == 0) {
                box.height = me.dom.scrollHeight;
            }
            else if ((anchor == 'l' || anchor == 'r') && box.width == 0) {
                box.width = me.dom.scrollWidth;
            }
            
            position = me.getPositioning();
            me.setSize(box.width, box.height);

            wrap = me.wrap({
                style: {
                    visibility: slideOut ? 'visible' : 'hidden'
                }
            });
            wrap.setPositioning(position);
            if (wrap.isStyle('position', 'static')) {
                wrap.position('relative');
            }
            me.clearPositioning('auto');
            wrap.clip();

            // This element is temporarily positioned absolute within its wrapper.
            // Restore to its default, CSS-inherited visibility setting.
            // We cannot explicitly poke visibility:visible into its style because that overrides the visibility of the wrap.
            me.setStyle({
                visibility: '',
                position: 'absolute'
            });
            if (slideOut) {
                wrap.setSize(box.width, box.height);
            }

            switch (anchor) {
                case 't':
                    anim = {
                        from: {
                            width: box.width + 'px',
                            height: '0px'
                        },
                        to: {
                            width: box.width + 'px',
                            height: box.height + 'px'
                        }
                    };
                    elStyle.bottom = '0px';
                    break;
                case 'l':
                    anim = {
                        from: {
                            width: '0px',
                            height: box.height + 'px'
                        },
                        to: {
                            width: box.width + 'px',
                            height: box.height + 'px'
                        }
                    };
                    elStyle.right = '0px';
                    break;
                case 'r':
                    anim = {
                        from: {
                            x: box.x + box.width,
                            width: '0px',
                            height: box.height + 'px'
                        },
                        to: {
                            x: box.x,
                            width: box.width + 'px',
                            height: box.height + 'px'
                        }
                    };
                    break;
                case 'b':
                    anim = {
                        from: {
                            y: box.y + box.height,
                            width: box.width + 'px',
                            height: '0px'
                        },
                        to: {
                            y: box.y,
                            width: box.width + 'px',
                            height: box.height + 'px'
                        }
                    };
                    break;
                case 'tl':
                    anim = {
                        from: {
                            x: box.x,
                            y: box.y,
                            width: '0px',
                            height: '0px'
                        },
                        to: {
                            width: box.width + 'px',
                            height: box.height + 'px'
                        }
                    };
                    elStyle.bottom = '0px';
                    elStyle.right = '0px';
                    break;
                case 'bl':
                    anim = {
                        from: {
                            x: box.x + box.width,
                            width: '0px',
                            height: '0px'
                        },
                        to: {
                            x: box.x,
                            width: box.width + 'px',
                            height: box.height + 'px'
                        }
                    };
                    elStyle.right = '0px';
                    break;
                case 'br':
                    anim = {
                        from: {
                            x: box.x + box.width,
                            y: box.y + box.height,
                            width: '0px',
                            height: '0px'
                        },
                        to: {
                            x: box.x,
                            y: box.y,
                            width: box.width + 'px',
                            height: box.height + 'px'
                        }
                    };
                    break;
                case 'tr':
                    anim = {
                        from: {
                            y: box.y + box.height,
                            width: '0px',
                            height: '0px'
                        },
                        to: {
                            y: box.y,
                            width: box.width + 'px',
                            height: box.height + 'px'
                        }
                    };
                    elStyle.bottom = '0px';
                    break;
            }

            wrap.show();
            wrapAnim = Ext.apply({}, obj);
            delete wrapAnim.listeners;
            wrapAnim = Ext.create('Ext.fx.Anim', Ext.applyIf(wrapAnim, {
                target: wrap,
                duration: 500,
                easing: 'ease-out',
                from: slideOut ? anim.to : anim.from,
                to: slideOut ? anim.from : anim.to
            }));

            // In the absence of a callback, this listener MUST be added first
            wrapAnim.on('afteranimate', function() {
                if (slideOut) {
                    me.setPositioning(position);
                    if (obj.useDisplay) {
                        me.setDisplayed(false);
                    } else {
                        me.hide();   
                    }
                }
                else {
                    me.clearPositioning();
                    me.setPositioning(position);
                }
                if (wrap.dom) {
                    wrap.dom.parentNode.insertBefore(me.dom, wrap.dom); 
                    wrap.remove();
                }
                me.setSize(box.width, box.height);
                animScope.end();
            });
            // Add configured listeners after
            if (listeners) {
                wrapAnim.on(listeners);
            }
        };

        me.animate({
            duration: obj.duration ? obj.duration * 2 : 1000,
            listeners: {
                beforeanimate: {
                    fn: beforeAnim
                },
                afteranimate: {
                    fn: function() {
                        if (wrapAnim && wrapAnim.running) {
                            wrapAnim.end();
                        }
                    }
                }
            }
        });
        return me;
    },

    
    /**
     * Slides the element out of view.  An anchor point can be optionally passed to set the end point
     * for the slide effect.  When the effect is completed, the element will be hidden (visibility = 
     * 'hidden') but block elements will still take up space in the document.  The element must be removed
     * from the DOM using the 'remove' config option if desired.  This function automatically handles 
     * wrapping the element with a fixed-size container if needed.  See the Fx class overview for valid anchor point options.
     * Usage:
     *<pre><code>
// default: slide the element out to the top
el.slideOut();

// custom: slide the element out to the right with a 2-second duration
el.slideOut('r', { duration: 2 });

// common config options shown with default values
el.slideOut('t', {
    easing: 'easeOut',
    duration: 500,
    remove: false,
    useDisplay: false
});
</code></pre>
     * @param {String} anchor (optional) One of the valid Fx anchor positions (defaults to top: 't')
     * @param {Object} options (optional) Object literal with any of the Fx config options
     * @return {Ext.core.Element} The Element
     */
    slideOut: function(anchor, o) {
        return this.slideIn(anchor, o, true);
    },

    /**
     * Fades the element out while slowly expanding it in all directions.  When the effect is completed, the 
     * element will be hidden (visibility = 'hidden') but block elements will still take up space in the document.
     * Usage:
     *<pre><code>
// default
el.puff();

// common config options shown with default values
el.puff({
    easing: 'easeOut',
    duration: 500,
    useDisplay: false
});
</code></pre>
     * @param {Object} options (optional) Object literal with any of the Fx config options
     * @return {Ext.core.Element} The Element
     */

    puff: function(obj) {
        var me = this,
            beforeAnim;
        obj = Ext.applyIf(obj || {}, {
            easing: 'ease-out',
            duration: 500,
            useDisplay: false
        });

        beforeAnim = function() {
            me.clearOpacity();
            me.show();

            var box = me.getBox(),
                fontSize = me.getStyle('fontSize'),
                position = me.getPositioning();
            this.to = {
                width: box.width * 2,
                height: box.height * 2,
                x: box.x - (box.width / 2),
                y: box.y - (box.height /2),
                opacity: 0,
                fontSize: '200%'
            };
            this.on('afteranimate',function() {
                if (me.dom) {
                    if (obj.useDisplay) {
                        me.setDisplayed(false);
                    } else {
                        me.hide();
                    }
                    me.clearOpacity();  
                    me.setPositioning(position);
                    me.setStyle({fontSize: fontSize});
                }
            });
        };

        me.animate({
            duration: obj.duration,
            easing: obj.easing,
            listeners: {
                beforeanimate: {
                    fn: beforeAnim
                }
            }
        });
        return me;
    },

    /**
     * Blinks the element as if it was clicked and then collapses on its center (similar to switching off a television).
     * When the effect is completed, the element will be hidden (visibility = 'hidden') but block elements will still 
     * take up space in the document. The element must be removed from the DOM using the 'remove' config option if desired.
     * Usage:
     *<pre><code>
// default
el.switchOff();

// all config options shown with default values
el.switchOff({
    easing: 'easeIn',
    duration: .3,
    remove: false,
    useDisplay: false
});
</code></pre>
     * @param {Object} options (optional) Object literal with any of the Fx config options
     * @return {Ext.core.Element} The Element
     */
    switchOff: function(obj) {
        var me = this,
            beforeAnim;
        
        obj = Ext.applyIf(obj || {}, {
            easing: 'ease-in',
            duration: 500,
            remove: false,
            useDisplay: false
        });

        beforeAnim = function() {
            var animScope = this,
                size = me.getSize(),
                xy = me.getXY(),
                keyframe, position;
            me.clearOpacity();
            me.clip();
            position = me.getPositioning();

            keyframe = Ext.create('Ext.fx.Animator', {
                target: me,
                duration: obj.duration,
                easing: obj.easing,
                keyframes: {
                    33: {
                        opacity: 0.3
                    },
                    66: {
                        height: 1,
                        y: xy[1] + size.height / 2
                    },
                    100: {
                        width: 1,
                        x: xy[0] + size.width / 2
                    }
                }
            });
            keyframe.on('afteranimate', function() {
                if (obj.useDisplay) {
                    me.setDisplayed(false);
                } else {
                    me.hide();
                }  
                me.clearOpacity();
                me.setPositioning(position);
                me.setSize(size);
                animScope.end();
            });
        };
        me.animate({
            duration: (obj.duration * 2),
            listeners: {
                beforeanimate: {
                    fn: beforeAnim
                }
            }
        });
        return me;
    },

   /**
    * Shows a ripple of exploding, attenuating borders to draw attention to an Element.
    * Usage:
<pre><code>
// default: a single light blue ripple
el.frame();

// custom: 3 red ripples lasting 3 seconds total
el.frame("#ff0000", 3, { duration: 3 });

// common config options shown with default values
el.frame("#C3DAF9", 1, {
    duration: 1 //duration of each individual ripple.
    // Note: Easing is not configurable and will be ignored if included
});
</code></pre>
    * @param {String} color (optional) The color of the border.  Should be a 6 char hex color without the leading # (defaults to light blue: 'C3DAF9').
    * @param {Number} count (optional) The number of ripples to display (defaults to 1)
    * @param {Object} options (optional) Object literal with any of the Fx config options
    * @return {Ext.core.Element} The Element
    */
    frame : function(color, count, obj){
        var me = this,
            beforeAnim;

        color = color || '#C3DAF9';
        count = count || 1;
        obj = obj || {};

        beforeAnim = function() {
            me.show();
            var animScope = this,
                box = me.getBox(),
                proxy = Ext.getBody().createChild({
                    style: {
                        position : 'absolute',
                        'pointer-events': 'none',
                        'z-index': 35000,
                        border : '0px solid ' + color
                    }
                }),
                proxyAnim;
            proxyAnim = Ext.create('Ext.fx.Anim', {
                target: proxy,
                duration: obj.duration || 1000,
                iterations: count,
                from: {
                    top: box.y,
                    left: box.x,
                    borderWidth: 0,
                    opacity: 1,
                    height: box.height,
                    width: box.width
                },
                to: {
                    top: box.y - 20,
                    left: box.x - 20,
                    borderWidth: 10,
                    opacity: 0,
                    height: box.height + 40,
                    width: box.width + 40
                }
            });
            proxyAnim.on('afteranimate', function() {
                proxy.remove();
                animScope.end();
            });
        };

        me.animate({
            duration: (obj.duration * 2) || 2000,
            listeners: {
                beforeanimate: {
                    fn: beforeAnim
                }
            }
        });
        return me;
    },

    /**
     * Slides the element while fading it out of view.  An anchor point can be optionally passed to set the 
     * ending point of the effect.
     * Usage:
     *<pre><code>
// default: slide the element downward while fading out
el.ghost();

// custom: slide the element out to the right with a 2-second duration
el.ghost('r', { duration: 2 });

// common config options shown with default values
el.ghost('b', {
    easing: 'easeOut',
    duration: 500
});
</code></pre>
     * @param {String} anchor (optional) One of the valid Fx anchor positions (defaults to bottom: 'b')
     * @param {Object} options (optional) Object literal with any of the Fx config options
     * @return {Ext.core.Element} The Element
     */
    ghost: function(anchor, obj) {
        var me = this,
            beforeAnim;

        anchor = anchor || "b";
        beforeAnim = function() {
            var width = me.getWidth(),
                height = me.getHeight(),
                xy = me.getXY(),
                position = me.getPositioning(),
                to = {
                    opacity: 0
                };
            switch (anchor) {
                case 't':
                    to.y = xy[1] - height;
                    break;
                case 'l':
                    to.x = xy[0] - width;
                    break;
                case 'r':
                    to.x = xy[0] + width;
                    break;
                case 'b':
                    to.y = xy[1] + height;
                    break;
                case 'tl':
                    to.x = xy[0] - width;
                    to.y = xy[1] - height;
                    break;
                case 'bl':
                    to.x = xy[0] - width;
                    to.y = xy[1] + height;
                    break;
                case 'br':
                    to.x = xy[0] + width;
                    to.y = xy[1] + height;
                    break;
                case 'tr':
                    to.x = xy[0] + width;
                    to.y = xy[1] - height;
                    break;
            }
            this.to = to;
            this.on('afteranimate', function () {
                if (me.dom) {
                    me.hide();
                    me.clearOpacity();
                    me.setPositioning(position);
                }
            });
        };

        me.animate(Ext.applyIf(obj || {}, {
            duration: 500,
            easing: 'ease-out',
            listeners: {
                beforeanimate: {
                    fn: beforeAnim
                }
            }
        }));
        return me;
    },

    /**
     * Highlights the Element by setting a color (applies to the background-color by default, but can be
     * changed using the "attr" config option) and then fading back to the original color. If no original
     * color is available, you should provide the "endColor" config option which will be cleared after the animation.
     * Usage:
<pre><code>
// default: highlight background to yellow
el.highlight();

// custom: highlight foreground text to blue for 2 seconds
el.highlight("0000ff", { attr: 'color', duration: 2 });

// common config options shown with default values
el.highlight("ffff9c", {
    attr: "backgroundColor", //can be any valid CSS property (attribute) that supports a color value
    endColor: (current color) or "ffffff",
    easing: 'easeIn',
    duration: 1000
});
</code></pre>
     * @param {String} color (optional) The highlight color. Should be a 6 char hex color without the leading # (defaults to yellow: 'ffff9c')
     * @param {Object} options (optional) Object literal with any of the Fx config options
     * @return {Ext.core.Element} The Element
     */ 
    highlight: function(color, o) {
        var me = this,
            dom = me.dom,
            from = {},
            restore, to, attr, lns, event, fn;

        o = o || {};
        lns = o.listeners || {};
        attr = o.attr || 'backgroundColor';
        from[attr] = color || 'ffff9c';
        
        if (!o.to) {
            to = {};
            to[attr] = o.endColor || me.getColor(attr, 'ffffff', '');
        }
        else {
            to = o.to;
        }
        
        // Don't apply directly on lns, since we reference it in our own callbacks below
        o.listeners = Ext.apply(Ext.apply({}, lns), {
            beforeanimate: function() {
                restore = dom.style[attr];
                me.clearOpacity();
                me.show();
                
                event = lns.beforeanimate;
                if (event) {
                    fn = event.fn || event;
                    return fn.apply(event.scope || lns.scope || window, arguments);
                }
            },
            afteranimate: function() {
                if (dom) {
                    dom.style[attr] = restore;
                }
                
                event = lns.afteranimate;
                if (event) {
                    fn = event.fn || event;
                    fn.apply(event.scope || lns.scope || window, arguments);
                }
            }
        });

        me.animate(Ext.apply({}, o, {
            duration: 1000,
            easing: 'ease-in',
            from: from,
            to: to
        }));
        return me;
    },

   /**
    * @deprecated 4.0
    * Creates a pause before any subsequent queued effects begin.  If there are
    * no effects queued after the pause it will have no effect.
    * Usage:
<pre><code>
el.pause(1);
</code></pre>
    * @param {Number} seconds The length of time to pause (in seconds)
    * @return {Ext.Element} The Element
    */
    pause: function(ms) {
        var me = this;
        Ext.fx.Manager.setFxDefaults(me.id, {
            delay: ms
        });
        return me;
    },

   /**
    * Fade an element in (from transparent to opaque).  The ending opacity can be specified
    * using the <tt>{@link #endOpacity}</tt> config option.
    * Usage:
<pre><code>
// default: fade in from opacity 0 to 100%
el.fadeIn();

// custom: fade in from opacity 0 to 75% over 2 seconds
el.fadeIn({ endOpacity: .75, duration: 2});

// common config options shown with default values
el.fadeIn({
    endOpacity: 1, //can be any value between 0 and 1 (e.g. .5)
    easing: 'easeOut',
    duration: 500
});
</code></pre>
    * @param {Object} options (optional) Object literal with any of the Fx config options
    * @return {Ext.Element} The Element
    */
    fadeIn: function(o) {
        this.animate(Ext.apply({}, o, {
            opacity: 1
        }));
        return this;
    },

   /**
    * Fade an element out (from opaque to transparent).  The ending opacity can be specified
    * using the <tt>{@link #endOpacity}</tt> config option.  Note that IE may require
    * <tt>{@link #useDisplay}:true</tt> in order to redisplay correctly.
    * Usage:
<pre><code>
// default: fade out from the element's current opacity to 0
el.fadeOut();

// custom: fade out from the element's current opacity to 25% over 2 seconds
el.fadeOut({ endOpacity: .25, duration: 2});

// common config options shown with default values
el.fadeOut({
    endOpacity: 0, //can be any value between 0 and 1 (e.g. .5)
    easing: 'easeOut',
    duration: 500,
    remove: false,
    useDisplay: false
});
</code></pre>
    * @param {Object} options (optional) Object literal with any of the Fx config options
    * @return {Ext.Element} The Element
    */
    fadeOut: function(o) {
        this.animate(Ext.apply({}, o, {
            opacity: 0
        }));
        return this;
    },

   /**
    * @deprecated 4.0
    * Animates the transition of an element's dimensions from a starting height/width
    * to an ending height/width.  This method is a convenience implementation of {@link #shift}.
    * Usage:
<pre><code>
// change height and width to 100x100 pixels
el.scale(100, 100);

// common config options shown with default values.  The height and width will default to
// the element&#39;s existing values if passed as null.
el.scale(
    [element&#39;s width],
    [element&#39;s height], {
        easing: 'easeOut',
        duration: .35
    }
);
</code></pre>
    * @param {Number} width  The new width (pass undefined to keep the original width)
    * @param {Number} height  The new height (pass undefined to keep the original height)
    * @param {Object} options (optional) Object literal with any of the Fx config options
    * @return {Ext.Element} The Element
    */
    scale: function(w, h, o) {
        this.animate(Ext.apply({}, o, {
            width: w,
            height: h
        }));
        return this;
    },

   /**
    * @deprecated 4.0
    * Animates the transition of any combination of an element's dimensions, xy position and/or opacity.
    * Any of these properties not specified in the config object will not be changed.  This effect 
    * requires that at least one new dimension, position or opacity setting must be passed in on
    * the config object in order for the function to have any effect.
    * Usage:
<pre><code>
// slide the element horizontally to x position 200 while changing the height and opacity
el.shift({ x: 200, height: 50, opacity: .8 });

// common config options shown with default values.
el.shift({
    width: [element&#39;s width],
    height: [element&#39;s height],
    x: [element&#39;s x position],
    y: [element&#39;s y position],
    opacity: [element&#39;s opacity],
    easing: 'easeOut',
    duration: .35
});
</code></pre>
    * @param {Object} options  Object literal with any of the Fx config options
    * @return {Ext.Element} The Element
    */
    shift: function(config) {
        this.animate(config);
        return this;
    }
});

/**
 * @class Ext.core.Element
 */
Ext.applyIf(Ext.core.Element, {
    unitRe: /\d+(px|em|%|en|ex|pt|in|cm|mm|pc)$/i,
    camelRe: /(-[a-z])/gi,
    opacityRe: /alpha\(opacity=(.*)\)/i,
    cssRe: /([a-z0-9-]+)\s*:\s*([^;\s]+(?:\s*[^;\s]+)*);?/gi,
    propertyCache: {},
    defaultUnit : "px",
    borders: {l: 'border-left-width', r: 'border-right-width', t: 'border-top-width', b: 'border-bottom-width'},
    paddings: {l: 'padding-left', r: 'padding-right', t: 'padding-top', b: 'padding-bottom'},
    margins: {l: 'margin-left', r: 'margin-right', t: 'margin-top', b: 'margin-bottom'},

    // Reference the prototype's version of the method. Signatures are identical.
    addUnits : Ext.core.Element.prototype.addUnits,

    /**
     * Parses a number or string representing margin sizes into an object. Supports CSS-style margin declarations
     * (e.g. 10, "10", "10 10", "10 10 10" and "10 10 10 10" are all valid options and would return the same result)
     * @static
     * @param {Number|String} box The encoded margins
     * @return {Object} An object with margin sizes for top, right, bottom and left
     */
    parseBox : function(box) {
        if (Ext.isObject(box)) {
            return {
                top: box.top || 0,
                right: box.right || 0,
                bottom: box.bottom || 0,
                left: box.left || 0
            };
        } else {
            if (typeof box != 'string') {
                box = box.toString();
            }
            var parts  = box.split(' '),
                ln = parts.length;
    
            if (ln == 1) {
                parts[1] = parts[2] = parts[3] = parts[0];
            }
            else if (ln == 2) {
                parts[2] = parts[0];
                parts[3] = parts[1];
            }
            else if (ln == 3) {
                parts[3] = parts[1];
            }
    
            return {
                top   :parseFloat(parts[0]) || 0,
                right :parseFloat(parts[1]) || 0,
                bottom:parseFloat(parts[2]) || 0,
                left  :parseFloat(parts[3]) || 0
            };
        }
        
    },
    
    /**
     * Parses a number or string representing margin sizes into an object. Supports CSS-style margin declarations
     * (e.g. 10, "10", "10 10", "10 10 10" and "10 10 10 10" are all valid options and would return the same result)
     * @static
     * @param {Number|String} box The encoded margins
     * @param {String} units The type of units to add
     * @return {String} An string with unitized (px if units is not specified) metrics for top, right, bottom and left
     */
    unitizeBox : function(box, units) {
        var A = this.addUnits,
            B = this.parseBox(box);
            
        return A(B.top, units) + ' ' +
               A(B.right, units) + ' ' +
               A(B.bottom, units) + ' ' +
               A(B.left, units);
        
    },

    // private
    camelReplaceFn : function(m, a) {
        return a.charAt(1).toUpperCase();
    },

    /**
     * Normalizes CSS property keys from dash delimited to camel case JavaScript Syntax.
     * For example:
     * <ul>
     *  <li>border-width -> borderWidth</li>
     *  <li>padding-top -> paddingTop</li>
     * </ul>
     * @static
     * @param {String} prop The property to normalize
     * @return {String} The normalized string
     */
    normalize : function(prop) {
        if (prop == 'float') {
            prop = Ext.supports.Float ? 'cssFloat' : 'styleFloat';
        }
        return this.propertyCache[prop] || (this.propertyCache[prop] = prop.replace(this.camelRe, this.camelReplaceFn));
    },

    /**
     * Retrieves the document height
     * @static
     * @return {Number} documentHeight
     */
    getDocumentHeight: function() {
        return Math.max(!Ext.isStrict ? document.body.scrollHeight : document.documentElement.scrollHeight, this.getViewportHeight());
    },

    /**
     * Retrieves the document width
     * @static
     * @return {Number} documentWidth
     */
    getDocumentWidth: function() {
        return Math.max(!Ext.isStrict ? document.body.scrollWidth : document.documentElement.scrollWidth, this.getViewportWidth());
    },

    /**
     * Retrieves the viewport height of the window.
     * @static
     * @return {Number} viewportHeight
     */
    getViewportHeight: function(){
        return window.innerHeight;
    },

    /**
     * Retrieves the viewport width of the window.
     * @static
     * @return {Number} viewportWidth
     */
    getViewportWidth : function() {
        return window.innerWidth;
    },

    /**
     * Retrieves the viewport size of the window.
     * @static
     * @return {Object} object containing width and height properties
     */
    getViewSize : function() {
        return {
            width: window.innerWidth,
            height: window.innerHeight
        };
    },

    /**
     * Retrieves the current orientation of the window. This is calculated by
     * determing if the height is greater than the width.
     * @static
     * @return {String} Orientation of window: 'portrait' or 'landscape'
     */
    getOrientation : function() {
        if (Ext.supports.OrientationChange) {
            return (window.orientation == 0) ? 'portrait' : 'landscape';
        }
        
        return (window.innerHeight > window.innerWidth) ? 'portrait' : 'landscape';
    },

    /** 
     * Returns the top Element that is located at the passed coordinates
     * @static
     * @param {Number} x The x coordinate
     * @param {Number} x The y coordinate
     * @return {String} The found Element
     */
    fromPoint: function(x, y) {
        return Ext.get(document.elementFromPoint(x, y));
    },
    
    /**
     * Converts a CSS string into an object with a property for each style.
     * <p>
     * The sample code below would return an object with 2 properties, one
     * for background-color and one for color.</p>
     * <pre><code>
var css = 'background-color: red;color: blue; ';
console.log(Ext.core.Element.parseStyles(css));
     * </code></pre>
     * @static
     * @param {String} styles A CSS string
     * @return {Object} styles
     */
    parseStyles: function(styles){
        var out = {},
            cssRe = this.cssRe,
            matches;
            
        if (styles) {
            // Since we're using the g flag on the regex, we need to set the lastIndex.
            // This automatically happens on some implementations, but not others, see:
            // http://stackoverflow.com/questions/2645273/javascript-regular-expression-literal-persists-between-function-calls
            // http://blog.stevenlevithan.com/archives/fixing-javascript-regexp
            cssRe.lastIndex = 0;
            while ((matches = cssRe.exec(styles))) {
                out[matches[1]] = matches[2];
            }
        }
        return out;
    }
});

/**
 * @class Ext.CompositeElementLite
 * <p>This class encapsulates a <i>collection</i> of DOM elements, providing methods to filter
 * members, or to perform collective actions upon the whole set.</p>
 * <p>Although they are not listed, this class supports all of the methods of {@link Ext.core.Element} and
 * {@link Ext.fx.Anim}. The methods from these classes will be performed on all the elements in this collection.</p>
 * Example:<pre><code>
var els = Ext.select("#some-el div.some-class");
// or select directly from an existing element
var el = Ext.get('some-el');
el.select('div.some-class');

els.setWidth(100); // all elements become 100 width
els.hide(true); // all elements fade out and hide
// or
els.setWidth(100).hide(true);
</code></pre>
 */
Ext.CompositeElementLite = function(els, root){
    /**
     * <p>The Array of DOM elements which this CompositeElement encapsulates. Read-only.</p>
     * <p>This will not <i>usually</i> be accessed in developers' code, but developers wishing
     * to augment the capabilities of the CompositeElementLite class may use it when adding
     * methods to the class.</p>
     * <p>For example to add the <code>nextAll</code> method to the class to <b>add</b> all
     * following siblings of selected elements, the code would be</p><code><pre>
Ext.override(Ext.CompositeElementLite, {
    nextAll: function() {
        var els = this.elements, i, l = els.length, n, r = [], ri = -1;

//      Loop through all elements in this Composite, accumulating
//      an Array of all siblings.
        for (i = 0; i < l; i++) {
            for (n = els[i].nextSibling; n; n = n.nextSibling) {
                r[++ri] = n;
            }
        }

//      Add all found siblings to this Composite
        return this.add(r);
    }
});</pre></code>
     * @type Array
     * @property elements
     */
    this.elements = [];
    this.add(els, root);
    this.el = new Ext.core.Element.Flyweight();
};

Ext.CompositeElementLite.prototype = {
    isComposite: true,

    // private
    getElement : function(el){
        // Set the shared flyweight dom property to the current element
        var e = this.el;
        e.dom = el;
        e.id = el.id;
        return e;
    },

    // private
    transformElement : function(el){
        return Ext.getDom(el);
    },

    /**
     * Returns the number of elements in this Composite.
     * @return Number
     */
    getCount : function(){
        return this.elements.length;
    },
    /**
     * Adds elements to this Composite object.
     * @param {Mixed} els Either an Array of DOM elements to add, or another Composite object who's elements should be added.
     * @return {CompositeElement} This Composite object.
     */
    add : function(els, root){
        var me = this,
            elements = me.elements;
        if(!els){
            return this;
        }
        if(typeof els == "string"){
            els = Ext.core.Element.selectorFunction(els, root);
        }else if(els.isComposite){
            els = els.elements;
        }else if(!Ext.isIterable(els)){
            els = [els];
        }

        for(var i = 0, len = els.length; i < len; ++i){
            elements.push(me.transformElement(els[i]));
        }
        return me;
    },

    invoke : function(fn, args){
        var me = this,
            els = me.elements,
            len = els.length,
            e,
            i;

        for(i = 0; i < len; i++) {
            e = els[i];
            if(e){
                Ext.core.Element.prototype[fn].apply(me.getElement(e), args);
            }
        }
        return me;
    },
    /**
     * Returns a flyweight Element of the dom element object at t