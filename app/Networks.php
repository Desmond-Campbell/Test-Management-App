<?php

namespace App;

use Illuminate\Support\Facades\DB;

class Networks
{    

  public static function invalidDomain( $domain ) {

    $reserved = explode( ' ', 'a about aboutus abuse account accounting accounts ad admanager admin admindashboard administrator administrators admins ads adsense adwords affiliate affiliates among anonymous api api1 api2 api3 app asset assets assets0-x assets1 assets2 assets3 assets4 assets5 atom b be beta billing billings blog board bookmark bookmarks bot bots bugs but buy by cache calendar camo category chat client clients cname code comment comments communities community contact content contributors coppa copyright could cpanel css css1 css2 css3 cssproxy customise customize dashboard data demo dev developer developers development diversity dmca docs donate download dreamwidth dw e-mail email embedded embedding ever evidently example examplecommunity exampleopenid examplesyn examplesyndicated exampleusername explore faq faqs favorite favorites favourite favourites feed feedback feeds files filterer for forum forums friend friends ftp general gettingstarted gift git google graph graphs guide guides hack help home hostmaster http https i icon icons im image images imap img img1 img2 img3 inbox index invite invoice invoices ios ipad iphone irc is jabber jars jobs js js1 js2 kb knowledge-base knowledgebase lab launchpad legal likely livejournal lj log login logs m mail main manage map maps media memories memory merchandise messages mobile mx my myaccount myaccounts network networks new news newsite not ns ns1 ns2 ns3 ns4 ns5 official on other outside pages paid partner partnerpage partners pay payment payments perlbal picture pictures policy pop pop3 popular portal possibly post postmaster press principles privacy private profile public random redirect register registration resolver root rss s s3 sandbox school schools search secure server servers service setting shop show signin signup sitemap sitenews sites sms smtp so social some something sorry spoofs ssl ssytem staff stage staging stat static statistics stats status still store story style styles support survey surveys svn syn syndicated system tag tags talk team teams terms termsofservice test that the they things ticket tickets tool tools tos trac translate typo up update updates upgrade upgrades upi upload uploads use used user username usernames users validation validations video videos volunteer volunteers want webdisk webmail webmaster webmasters whm whois wiki ww www www1 www2 wwww x xml xmpp' );

    if ( in_array( strtolower( $domain ), $reserved ) ) return true;

    if ( in_array( strtolower( str_replace( '-', '', $domain ) ), $reserved ) ) return true;

    if ( !self::isDomainAvailable( strtolower( $domain ) ) ) return true;
    
    if ( !self::isDomainAvailable( strtolower( str_replace( '-', '', $domain ) ) ) ) return true;

    return false;

  }

  public static function isDomainAvailable( $domain ) {
    
    $banned_domains_csv = 'admin, login, administrator, blog, dashboard, admindashboard, images?, img, files?, videos?, help, support, cname, test, cache, mystore, biz, investors?
    api\d*, js, static, s\d*,ftp, e?mail,webmail, webdisk, ns\d*, register, join, registration, pop\d?, beta\d*, stage, deploy, deployment,staging, testers?, https?, donate, payments, smtp,
    ad, admanager, ads, adsense, adwords?, about, abuse, affiliate, affiliates, store, shop, clients?, code, community, forum?, discussions?, order, buy, cpanel, store, payment,
    whm, dev, devel, developers?, development, docs?, whois, signup, gettingstarted, home, invoice, invoices, ios, ipad, iphone, logs?, my, status, networks?, 
    new, newsite, news, partner, partners, partnerpage, popular, wiki, redirect, random, public, resolver, sandbox, search, servers?, service,uploads?, validation,
    signin, signup, sitemap, sitenews, sites, sms, sorry, ssl, staging,features, stats?, statistics?, graphs?, surveys?, talk, trac, git, svn, translate, validations, webmaster,
    www\d*, feeds?, rss, asset[s\d]*, cp\d*, control panel, online, media, jobs?, secure, demo, i\d*, img\d*, css\d*, js\d*';

    $regex = $banned_domains_csv;
    $regex = preg_replace('#\s#si', '', $regex);
    $regex = preg_replace("#,+#si", '|', $regex);
    $regex = trim($regex, ',');
    $regex = '#^(?:' . $regex . ')$#si';

    $status = !preg_match($regex, $domain);

    return $status;
  
  }

  public static function getDatabase( $domain ) {

    $network = DB::table( 'networks' )->where( 'domain', $domain )->first();

    if ( !$network ) {

      return "NULL";

    } else {

      return env( 'NETWORK_DATABASE_PREFIX' ) . str_pad( $network->id, 10, "0", STR_PAD_LEFT );

    }

  }

}

