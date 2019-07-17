<?php
add_action( 'admin_enqueue_scripts', 'load_styles' );
add_action( 'admin_enqueue_scripts', 'register_scripts' );

/**
 * Includes the styles for the react app
 */
function load_styles() {
    $screen = get_current_screen();
    if ( is_app_page() ){
        wp_enqueue_style( "ux-jam-order-management-admin", plugin_dir_url( dirname( __FILE__ ) ) . '/style.css' );
        wp_enqueue_style( "ux-jam-order-management-css", plugin_dir_url( dirname( __FILE__ ) ) . 'js/part.css' );
        wp_enqueue_style( "ux-jam-order-management-css-2", plugin_dir_url( dirname( __FILE__ ) ) . 'js/main.css' );
    }
}
  
/**
 * Registers the scripts
 */
function register_scripts() {
    $screen = get_current_screen();
    if ( is_app_page() ){
        /* React JS  */
        wp_register_script( 'jam-react', 'https://unpkg.com/react@16/umd/react.production.min.js', null, null, true );
    
        /* React JS DOM  */
        wp_register_script( 'jam-react-dom', 'https://unpkg.com/react-dom@16/umd/react-dom.production.min.js', null, null, true );
    
        /* Babel  */
        wp_register_script( 'jam-babel', 'https://unpkg.com/babel-standalone@6/babel.min.js', null, null, true );
    
        /* Product Editor */
        wp_register_script( "ux-jam-order-management-js", plugin_dir_url( dirname( __FILE__ ) ) . 'js/main.js' );
        
        // wp_register_script( 'jam-editor', get_template_directory_uri() . '/js/build/static/js/runtime~main.229c360f.js', array( 'jam-react', 'jam-react-dom', 'jam-babel' ), null, true );
        wp_register_script( 'ux-jam-order-management-js-1', plugin_dir_url( dirname( __FILE__ ) ) . 'js/part.chunk.js', array( 'jam-react', 'jam-react-dom', 'jam-babel' ), null, true );
        wp_register_script( 'ux-jam-order-management-js-2', plugin_dir_url( dirname( __FILE__ ) ) . 'js/main.chunk.js', array( 'jam-react', 'jam-react-dom', 'jam-babel' ), null, true );

        wp_localize_script( "ux-jam-order-management-js-1", "wpApiSettings", array( "root" => esc_url_raw( rest_url() ), "nonce" => wp_create_nonce( "wp_rest" ) ) );
    }
}

/**
 * Enqueues the scripts and renders the root element
 */
function render_jam_app() {
    // wp_enqueue_script( 'jam-react' );
    // wp_enqueue_script( 'jam-react-dom' );
    // wp_enqueue_script( 'jam-babel' );
    // wp_enqueue_script( 'ux-jam-order-management-js' );
    echo '<div id="root"></div><script>!function(l){function e(e){for(var r,t,n=e[0],o=e[1],u=e[2],f=0,i=[];f<n.length;f++)t=n[f],p[t]&&i.push(p[t][0]),p[t]=0;for(r in o)Object.prototype.hasOwnProperty.call(o,r)&&(l[r]=o[r]);for(s&&s(e);i.length;)i.shift()();return c.push.apply(c,u||[]),a()}function a(){for(var e,r=0;r<c.length;r++){for(var t=c[r],n=!0,o=1;o<t.length;o++){var u=t[o];0!==p[u]&&(n=!1)}n&&(c.splice(r--,1),e=f(f.s=t[0]))}return e}var t={},p={1:0},c=[];function f(e){if(t[e])return t[e].exports;var r=t[e]={i:e,l:!1,exports:{}};return l[e].call(r.exports,r,r.exports,f),r.l=!0,r.exports}f.m=l,f.c=t,f.d=function(e,r,t){f.o(e,r)||Object.defineProperty(e,r,{enumerable:!0,get:t})},f.r=function(e){"undefined"!=typeof Symbol&&Symbol.toStringTag&&Object.defineProperty(e,Symbol.toStringTag,{value:"Module"}),Object.defineProperty(e,"__esModule",{value:!0})},f.t=function(r,e){if(1&e&&(r=f(r)),8&e)return r;if(4&e&&"object"==typeof r&&r&&r.__esModule)return r;var t=Object.create(null);if(f.r(t),Object.defineProperty(t,"default",{enumerable:!0,value:r}),2&e&&"string"!=typeof r)for(var n in r)f.d(t,n,function(e){return r[e]}.bind(null,n));return t},f.n=function(e){var r=e&&e.__esModule?function(){return e.default}:function(){return e};return f.d(r,"a",r),r},f.o=function(e,r){return Object.prototype.hasOwnProperty.call(e,r)},f.p="/";var r=window.webpackJsonp=window.webpackJsonp||[],n=r.push.bind(r);r.push=e,r=r.slice();for(var o=0;o<r.length;o++)e(r[o]);var s=n;a()}([])</script>';
    wp_enqueue_script( 'ux-jam-order-management-js-1' );
    wp_enqueue_script( 'ux-jam-order-management-js-2' );
}

/**
 * Enqueues the scripts and renders the root element
 */
function render_jam_options() {
    require_once plugin_dir_path( dirname(__FILE__) ) . '/admin/options-page.php';
}

function is_app_page(){
    $screen = get_current_screen();
    if ( strpos($screen->id, 'order-management') !== false && gettype(strpos($screen->id, 'order-management-options')) !== "integer" ){
        return true;
    } else {
        return false;
    }
}