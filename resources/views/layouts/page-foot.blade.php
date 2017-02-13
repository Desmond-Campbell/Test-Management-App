    <div ng-controller="DialogCtrl"></div>
    <div ng-controller="MainCtrl">
        <input type="hidden" name="page-hash" id="page-hash" value="<?=Config::get('trackerhashid')?>" />
        <input type="hidden" name="time-value" id="time-value" value="" />
    </div>

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script>window.jQuery || document.write('<script src="/js/vendor/jquery-2.2.1.min.js"><\/script>')</script>
    <script src="/js/vendor/node_modules/angular/angular.js"></script> 
    <script src="/js/vendor/node_modules/angular-aria/angular-aria.js"></script> 
    <script src="/js/vendor/node_modules/angular-animate/angular-animate.js"></script> 
    <script src="/js/vendor/node_modules/angular-material/angular-material.js"></script>
    <script src="/js/vendor/tinycolor-min.js"></script>
    <script src="/js/vendor/md-color-picker/mdColorPicker.js"></script>

    <script src="/js/app.js"></script>
    @yield('javascript')
    <script src="/js/controllers/Controller.js"></script>
    <script src="/js/vendor/moment.js"></script>
    <script src="/js/vendor/angular-moment.js"></script>
    <script src="/js/vendor/ifvisible/ifvisible.js"></script>
    <script src="/js/vendor/timeme.js"></script>
    <script src="/js/la.js"></script>
    <script src="/js/vendor/bootstrap/bootstrap.min.js"></script>
    <script src="/js/vendor/bootstrap/docs.min.js"></script>
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="/js/vendor/bootstrap/ie10-viewport-bug-workaround.js"></script>