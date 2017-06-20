(function($) {
    /*
    Validation Singleton
    */
    var Validation = function() {
        //dimiourgoume ta rules pou 8eloume
        var rules = {
            //rule gia to email
            email : {
               check: function(value) {
                   
                   if(value)
                       return testPattern(value,"[a-z0-9!#$%&'*+/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&'*+/=?^_`{|}~-]+)*@(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])");
                   return true;
               },
               msg : "Το πεδίο πρέπει να είναι μια <em>έγκυρη διεύθυνση email</em>."
            },
			// rule gia to general require
            required : {
                
               check: function(value) {

                   if(value)
                       return true;
                   else
                       return false;
               },
               msg : "Το πεδίο είναι <em>απαραίτητο</em>."
            }
        }
		// function gia to pattern test
        var testPattern = function(value, pattern) {

            var regExp = new RegExp(pattern,"");
            return regExp.test(value);
        }
        return {
            
            addRule : function(name, rule) {

                rules[name] = rule;
            },
            getRule : function(name) {

                return rules[name];
            }
        }
    }
    
    // pernoume ta fields apo to form
    var Form = function(form) {
        
        var fields = [];
    
        form.find("[validation]").each(function() {
            var field = $(this);
            if(field.attr('validation') !== undefined) {
                fields.push(new Field(field));
            }
        });
        this.fields = fields;
    }
	// pros8etoume to form object epipleon functions
    Form.prototype = {
        validate : function() {

            for(field in this.fields) {
                
                this.fields[field].validate();
            }
        },
        isValid : function() {
            
            for(field in this.fields) {
                
                if(!this.fields[field].valid) {
            
                    this.fields[field].field.focus();
                    return false;
                }
            }
            return true;
        }
    }
    
    //pros8etoume listeners gia to change tou ka8e field kai kanoume init tin katastash tou se NOT valid
    var Field = function(field) {

        this.field = field;
        this.valid = false;
        this.attach("change");
    }
    Field.prototype = {
        
        attach : function(event) {
        
            var obj = this;
            if(event == "change") {
                obj.field.bind("change",function() {
                    return obj.validate();
                });
            }
            if(event == "keyup") {
                obj.field.bind("keyup",function(e) {
                    return obj.validate();
                });
            }
        },
        validate : function() {
            var topOffset = 2;
			var leftOffset = 10;
            var obj = this,
                field = obj.field,
                errorClass = "errorlist",
                errorlist = $(document.createElement("ul")).addClass(errorClass),
				
                types = field.attr("validation").split(" "),
                container = field.parent(),
                errors = []; 

            errorlist.css('position','absolute')
			.css('top',(field.position().top + topOffset + 'px'))
			.css('left',(field.position().left + field.width() + leftOffset + 'px')).fadeIn();
			
            field.next(".errorlist").remove();
            for (var type in types) {

                var rule = $.Validation.getRule(types[type]);
                if(!rule.check(field.val())) {

                    field.addClass("errorField");
                    errors.push(rule.msg);
                }
            }
            if(errors.length) {

                obj.field.unbind("keyup")
                obj.attach("keyup");
                field.after(errorlist.empty());
                for(error in errors) {
                
                    errorlist.append("<li>"+ errors[error] +"</li>");        
                }
                obj.valid = false;
            } 
            else {
                errorlist.remove();
                field.removeClass("errorField");
                obj.valid = true;
            }
        }
    }
    
    /*
    Validation extends jQuery prototype
    */
    $.extend($.fn, {
        
        validation : function() {
            
            var validator = new Form($(this));
            $.data($(this)[0], 'validator', validator);
            
            $(this).bind("submit", function(e) {
                validator.validate();
                if(!validator.isValid()) {
                    e.preventDefault();
                }
            });
        },
        validate : function() {
            
            var validator = $.data($(this)[0], 'validator');
            validator.validate();
            return validator.isValid();
            
        }
    });
    $.Validation = new Validation();
})(jQuery);