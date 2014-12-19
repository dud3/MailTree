angular.module('mailTree')
.factory('ErrorHandlerSvc', ['$http', '$sanitize', function($http, $sanitize) {

  var errorHnadler.error = {

      element: "",
      elements: [],   
      ids: [],
      containarr: [], 

      raise: function (id, title, content, trigger, placement) {
        this.element = $("#" + id).tooltip({
            delay: { show: 100, hide: 0 },
            animation: true,
            placement: (placement) ? placement : 'top',
            title: title,
            trigger: (trigger) ? trigger : 'manual',
            html: true
        });

        this.elements.push(this.element);
        this.ids.push(id);
        if (!content) {
            content = '';
        }

        this.containarr.push(content);
        this.element.tooltip('show');
      },

      contains: function(content) {
        for(var i = this.containarr.length; i--;) {
          if(this.containarr[i] === content) {
              return 1;
          }
        }
        return 0;
      },

      destroy: function(id) {
        for(var i = this.ids.length; i--;) {
          if(this.ids[i] === id) {
              this.elements[i].tooltip('destroy');
              this.elements.splice(i, 1);
              this.ids.splice(i, 1);
              this.containarr.splice(i, 1);
          }
        }
      },

      destroyAll: function() {
          angular.forEach(this.elements, function(items){
              items.tooltip('destroy');
          });
          this.elements = [];
          this.ids = [];
          this.containarr = [];
      },

      displayError: {

        errorType: {

            // Empty field errors
            "empty_error": function(element, attr_name) {
                errorHnadler.error.raise(""+ element, "Please enter the " + attr_name);
            },

            "required_error": function(element, attr_name) {
                errorHnadler.error.raise("" + element, "Please choose an " + attr_name);
            },

            "email_format_error": function(element, attr_name) {
                errorHnadler.error.raise("" + element, "The " + attr_name + " has a wrong format");
            },

            "date_in_future_error": function(element, attr_name) {
                errorHnadler.error.raise("" + element, "The " + attr_name + " should not be in the future");
            },

        },

        build_up_rules: function(elements, rules) {

            this.destroyAll();

            var _pass = true;

            for(var i = 0; i < elements.length; i++) {

                for(var j = 0; j < rules.length; j++) {

                    if(rules[j] == 'if_empty') {
                        if(element[i].val() === '' || element[i].val().length === 0 || typeof element[i] !== 'undefined') {
                            this.errorType.empty_error(element[i].attr('id'), element[i].attr('name'));
                            _pass = false;
                        }
                    }

                    if(rules[j] == 'if_required') {
                        if(element[i].val().length === 0) {
                            this.errorType.required_error(element[i].attr('id'), element[i].attr('name'));
                        }
                    }

                    if(rules[i] == 'if_future') {
                        var seldate = new Date(Number(somedate.slice(6,10)), Number(somedate.slice(3,5)) - 1, Number(somedate.slice(0,2)));
                        var nowdate = new Date();
                        if(element[i].val() > nowdate.setUTCDate(nowdate.getUTCDate() + 1)) {
                          errorHnadler.error.displayError.errorType.date_in_future_error(element[i].attr('id'), element[i].attr('name'));
                          _pass = false;
                        }
                    }

                    if(rules[i] == 'if_to_many_hours') {
                        if(element[i] !== parseInt(element[i]) {
                            console.log("This might not be an integer!");
                        }
                        element[i] = parseInt(element[i]);
                        if(element[i].val() > 24) {
                            errorHnadler.error.displayError.errorType.too_many_hours_error(element[i].attr('id'), element[i].attr('name'));
                        }
                    }

                    if(rules[i] == 'if_duration_under') {
                        if(element[i] !== parseInt(element[i]) {
                            console.log("This might not be an integer!");
                        }
                        element[i] = parseInt(element[i]);
                        if(element[i].val() < 0) {
                            this.errorType.duration_under(element[i].attr('id'), element[i].attr('name'));
                        }
                    }

                }
            }

            return _pass;

        },

        //
        // @note.0.1: Before everything we need to pass the element using jquery(we could have been using pure js as well), such as: $("#x-element")
        // like this we can access anything about that element, for now we shall use $("#x-element").attr('id') to get the id of the element and
        // $("#x-element").attr('name') to get the name of the element, the name of the element refers on the text of the message, such as:
        // "The " + attr_name + " should not be in the future" => The " + "aircraft" + " should not be in the future", or whatever
        // we would want to refer to.
        // 
        // @note.0.2: For this to work properly each input has to have it's unique ID, the name of the element can be the same in some cases,
        // but still having them unique as well would make everything easier.
        // 
        // @note.0.3: element(s)-rule(s) relationship: one-to-one, many-to-one, one-to-many, many-to-many, basically anything.
        // 
        // Ideally pass element param as an object, specifying the rules as well, such as:
        // 
        // [ { elements: [ $("#x-element") ], rules: ['if_empty'] }, { elements: [ $("#x-element") ], rules: ['if_empty', 'if_date', 'if_future'] } ]
        // 
        fire: function(targets) {

          var config = {

          };

            // Local flag
            var _flag = true;

            if(typeof elements !== 'object') {
                console.log("the pearam should be an object, even if it contains only one element and rule.");
                return false;
            }

            // Destroy all the error each time the service is called.
            errorHnadler.error.destroyAll();

            for(var target in targets) {
                _flag = this.build_up_rules(target.elements, target.rules);
            }

            return _flag;

          }

      }

  }

  return errorHnadler;

}]);
