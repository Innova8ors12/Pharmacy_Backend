$(window).on('load', function() {
    setTimeout(function() {
        $(".preloader").delay(300).fadeOut(400);
    });
});

$(document).ready(function() {
    // $('#userdatatable').DataTable({
    //     responsive: true,
    //     "bLengthChange": false,
    //     language: {
    //         sLengthMenu: "Show _MENU_"
    //     },
       
    //     order: [
    //         [1, 'asc']
    //     ]


    // });
    // $('#datatable').DataTable({
    //     responsive: true,
    //     "bLengthChange": false,
    //     language: {
    //         sLengthMenu: "Show _MENU_"
    //     },



    // });
    
    $("#userdatatable").DataTable({
  // responsive: true,
  responsive: false,
  scrollX: false,
  language: {
    sLengthMenu: "Show _MENU_",
  },
  order: [[1, "asc"]],
  initComplete: function (settings, json) {
    $(".datatable").wrap(
      "<div class='drag mb-4 user-select-none' style='overflow:auto; width:100%;'></div>"
    );
  },
});

    //DataTable custom search field

    $("#custom-filter").on("input", function(e) {
        e.preventDefault();
        $('#userdatatable, #datatable').DataTable().search($(this).val()).draw();
    });
    $("#filter-status-1").on("change", function() {
        $('#userdatatable, #datatable').DataTable().search($(this).val()).draw('');
    });
    $("#filter-status-2").on("change", function() {
        $('#userdatatable, #datatable').DataTable().search($(this).val()).draw('');
    });
    /*===================================*
    01. LOADING JS
    /*===================================*/

    /*===================================*
        start window scroll
    /*===================================*/
    $(window).on('scroll', function() {
        var scroll = $(window).scrollTop();

        if (scroll >= 250) {
            $('nav.navbar').addClass('nav-fixed');
        } else {
            $('nav.navbar').removeClass('nav-fixed');
        }

    });
    /*===================================*
            end window scroll
        /*===================================*/



    // ################### start select option #################


    var x, i, j, selElmnt, a, b, c;
    /*look for any elements with the class "custom-select":*/
    x = document.getElementsByClassName("custom-select");
    for (i = 0; i < x.length; i++) {
        selElmnt = x[i].getElementsByTagName("select")[0];
        /*for each element, create a new DIV that will act as the selected item:*/
        a = document.createElement("DIV");
        a.setAttribute("class", "select-selected");
        a.innerHTML = selElmnt.options[selElmnt.selectedIndex].innerHTML;
        x[i].appendChild(a);
        /*for each element, create a new DIV that will contain the option list:*/
        b = document.createElement("DIV");
        b.setAttribute("class", "select-items select-hide");
        for (j = 1; j < selElmnt.length; j++) {
            /*for each option in the original select element,
            create a new DIV that will act as an option item:*/
            c = document.createElement("DIV");
            c.innerHTML = selElmnt.options[j].innerHTML;
            c.addEventListener("click", function(e) {
                /*when an item is clicked, update the original select box,
                and the selected item:*/
                var y, i, k, s, h;
                s = this.parentNode.parentNode.getElementsByTagName("select")[0];
                h = this.parentNode.previousSibling;
                for (i = 0; i < s.length; i++) {
                    if (s.options[i].innerHTML == this.innerHTML) {
                        s.selectedIndex = i;
                        h.innerHTML = this.innerHTML;
                        y = this.parentNode.getElementsByClassName("same-as-selected");
                        for (k = 0; k < y.length; k++) {
                            y[k].removeAttribute("class");
                        }
                        this.setAttribute("class", "same-as-selected");
                        break;
                    }
                }
                h.click();
            });
            b.appendChild(c);
        }
        x[i].appendChild(b);
        a.addEventListener("click", function(e) {
            /*when the select box is clicked, close any other select boxes,
            and open/close the current select box:*/
            e.stopPropagation();
            closeAllSelect(this);
            this.nextSibling.classList.toggle("select-hide");
            this.classList.toggle("select-arrow-active");
        });
    }

    function closeAllSelect(elmnt) {
        /*a function that will close all select boxes in the document,
        except the current select box:*/
        var x, y, i, arrNo = [];
        x = document.getElementsByClassName("select-items");
        y = document.getElementsByClassName("select-selected");
        for (i = 0; i < y.length; i++) {
            if (elmnt == y[i]) {
                arrNo.push(i)
            } else {
                y[i].classList.remove("select-arrow-active");
            }
        }
        for (i = 0; i < x.length; i++) {
            if (arrNo.indexOf(i)) {
                x[i].classList.add("select-hide");
            }
        }
    }

    document.addEventListener("click", closeAllSelect);

    // ################### end select option #################


});


// ################### start toggle menu button #################
window.addEventListener('DOMContentLoaded', event => {

    // Toggle the side navigation
    const sidebarToggle = document.body.querySelector('#sidebarToggle');
    if (sidebarToggle) {

        sidebarToggle.addEventListener('click', event => {
            event.preventDefault();
            document.body.classList.toggle('sb-sidenav-toggled');
            localStorage.setItem('sb|sidebar-toggle', document.body.classList.contains('sb-sidenav-toggled'));
        });
    }

});
// ################### end toggle menu button #################


