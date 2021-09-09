//* Preface
// var site_name;
// var site_url;

//Get site info
 const siteInfo = getData('config.json').then(response => {
    var site_name = response.sitename
   var  site_url = response.siteurl;
   var  site_tag = response.tagline;
 let sitename_val =  document.createElement('input')
 let siteurl_val =   document.createElement('input')
    sitename_val.setAttribute('id','info_site_name')
    siteurl_val.setAttribute('id','info_site_url')
    sitename_val.setAttribute('value', site_name)
    sitename_val.setAttribute('class', 'd-none')
    siteurl_val.setAttribute('value', site_url)
    siteurl_val.setAttribute('class', 'd-none')
     document.getElementById('footerName').innerHTML= site_name
     document.getElementById('site-title').innerText= site_name
     // document.querySelector('title').innerText= site_name +' - '+site_tag
   let body_info = document.querySelector("body")
    body_info.insertBefore(sitename_val, body_info.firstChild)
    body_info.insertBefore(siteurl_val, body_info.firstChild)
    //Call site name

     return response
})


//0) Year footer
let date = new Date();
let year = date.getFullYear();
document.getElementById('footerDate').innerHTML = year


//1) Return Confirm on page close or reload
window.onbeforeunload = function (event) {
    var message = 'Important: Please click on \'Save\' button to leave this page.';
    if (typeof event == 'undefined') {
        event = window.event;
    }
    if (event) {
        event.returnValue = message;
    }
    return message;
};

$(function () {
    $("a").not('#lnkLogOut').click(function () {
        window.onbeforeunload = null;
    });
    $(".btn").click(function () {
        window.onbeforeunload = null;
    });
});
// window.onbeforeunload = function(e) {
//     return ""
// }
//End**********

//2) Page Loader


// window.onload = function () {
    class loader {
        onReady(callback) {
            Notiflix.Loading.Circle('Please wait...');
            var intervalId = window.setInterval(function() {
                if (document.getElementsByTagName('body')[0] !== undefined) {
                    window.clearInterval(intervalId);
                    callback.call(this);
                }
            }, 2000);

        }
        setVisible(selector, visible) {
            document.querySelector(selector).style.display = visible ? 'block' : 'none';
        }
    }

    var pageloader = new loader();


    //View specification when shared url is viewed

        pageloader.onReady(function() {
            var loader = Notiflix.Loading.Remove();
            pageloader.setVisible('body', true);
            pageloader.setVisible(loader, false);

        });



//End************


//3) Fetch Data function
async function getData( url='') {
    const response = await fetch(
        url,
        {
            method: "GET",
            mode: "same-origin",
            cache: 'no-cache',
            credentials: "same-origin",
            headers: {
                "Content-Type": "application/json",
                "Accept":       "application/json" ,
            },
            redirect: 'follow',
            referrerPolicy: 'no-referrer',
        },
    );

    return response.json( );
}

//4) Post Data function

async function postData(url='', data=''){
    const response = await fetch(
        url,
        {
            method: "POST",
            mode: "same-origin",
            cache: 'no-cache',
            credentials: "same-origin",
            headers: {
                "Content-Type": "application/json",
                "Accept":       "application/json" ,
            },
            redirect: 'follow',
            referrerPolicy: 'no-referrer',
            body: JSON.stringify( data ),
        },
    );

    return response.json( );

}

//5) Notiflix Init Function

Notiflix.Notify.Init({
    fontFamily:"Quicksand",
    useGoogleFont:true,
    position:"left-bottom",
    borderRadius:"0px",
    clickToClose: true,
    pauseOnHover: true,
    width:"200px",
    success: {
        background:"#7dc855",
    },

});

function successShare() {
    Notiflix.Notify.Success('Link Shared')
}
function errorMsg() {
    Notiflix.Report.Failure('Error','Search failed, please try again','Ok');
}
//Api Path
const apiPath = 'core/controllers/lib/'

//6) Get Phone Manufactuer Brands
getData(apiPath+'?brands=brands').then( response => {
    var res = response.data
    var array = [];
    res.forEach( function (index, value) {

        var htm= index.title
        var parse = array.push(htm)
    })
    $("#phonebrand" ).autocomplete({
        maxShowItems: 10,
        source: array
    })
});

//7) Get Phone Models
document.querySelector('#phonebrand').addEventListener('change', () => {
    const phonebrand = document.getElementById('phonebrand').value.trim()
    Notiflix.Loading.Circle('Processing..')
    getData(apiPath+'?query='+phonebrand).then( response => {
        var res = response.data

        if (response.status != "error"){
            var cp = '<option></option>';
            res.forEach( (index, value) => {
                cp+= '<option data-token="'+index.slug+'" value="'+index.slug+'" >'+index.title+'</option>'
            })
            if ($(this).length == 1) {
                document.getElementById('phonemodel').classList.remove('d-none')

                document.getElementById('searchphone').classList.remove('d-none')
                Notiflix.Loading.Remove()
            }

            $('#phonemodel').select2({
                theme:'bootstrap-5',
                placeholder: "Select Phone Model",
                dropdownCssClass: 'form-control',
                containerCssClass: 'form-control'
            }).html(cp)
        }else  {
            Notiflix.Loading.Remove()
            errorMsg()
        }
    })
})
//8) View Phone Specification
function getSpec(slug) {

    Notiflix.Loading.Circle('Processing..')
    if ( phonebrand !="" || phonemodel != ""){

        getData(apiPath+'?slug='+slug).then( result => {
            const resp = result.data
            document.getElementById('mainTitle').innerHTML =result.title;
            document.getElementById('secondtitle').innerHTML = result.title+' '+ '- SPECIFICATIONS';
           let rawbatter = result.data.battery.type.split(', ')
            document.getElementById('battery').innerHTML = rawbatter[0]
            document.getElementById('phoneImg').setAttribute("src", result.img);
            document.getElementById('phoneSlug').setAttribute("value", slug)
            let platfom = result.data;
            if(('platform' in platfom)) {
                let memor = result.data.memory.internal;
                let  arrMemotext = memor.split(' ')
                let display = result.data.display.size
                let arrDisplayText = display.split(' ')
                var proccessor = result.data.platform.cpu
                let chipset = result.data.platform.chipset
                let arrProccessText = proccessor.split(' ')
                let arrChipseText = chipset.split(' ')
                document.getElementById('ram').innerHTML = arrMemotext[1]
                document.getElementById('storage').innerHTML = arrMemotext[0]
                document.getElementById('display').innerHTML = arrDisplayText[0] +' '+ arrDisplayText[1].replace(',', "")
                let prochip = arrProccessText[0] +' '+arrChipseText
                let prochnew = prochip.split(',')
                document.getElementById('processor').innerHTML = prochnew[0]+' '+prochnew[1]
                let cam = result.data['main camera']
                if (('features' in cam)) {
                    let camft = cam.features.split(',')
                    document.getElementById('camera').innerHTML = camft[0]
                }else if (('single' in cam)){
                    let camsg = cam.single.split(',')
                    document.getElementById('camera').innerHTML =camsg
                }else  {
                    errorMsg()
                }
            }else {
                document.querySelector('#ram, #storage, #display, #processor, #camera').innerHTML = 'N/A'
            }

            document.getElementById('phoneImgFancy').setAttribute("href", result.img);
            var cb = '<div class="aps-group">';
            $.each(resp, function (t,v ) {
                cb +=   '<h3 class="aps-group-title text-uppercase" style="color: #7dc855">';
                cb += t;
                cb +=   '  </h3>';
                $.each(v , function (tref, va) {
                    cb +=   '     <div class="aps-specs-table">';
                    cb +=   '     <div class="aps-specs-scroller">';
                    cb +=   '            <ul class="aps-specs-list">';
                    cb +=   '           <li>';
                    cb +=   '                  <div class="aps-attr-title text-capitalize">';
                    cb +=   '                 <strong class="aps-term aps-tooltip">';
                    cb += tref.replace("_", " ");
                    cb +=     '</strong>';
                    cb +=   '    <span class="aps-tooltip-data ">' ;
                    cb +=       '<strong>' ;
                    cb +=   tref.replace("_", " ");
                    cb +=   '</strong> </span> </div>';
                    cb +=   '          <div class="aps-attr-value">'
                    cb +=   '         <span class="aps-1co text-capitalize">' ;
                    cb +=   va.replace("_", " ")
                    cb +=   '</span>';
                    cb +=   '                  </div>';
                    cb +=   '          </li>';
                    cb +=   '         </ul>';
                    cb +=   '    </div>';
                    cb +=   '  </div>';
                    cb +=   '</div>';

                })
            })

            cb +=' </div>';

            document.getElementById('ph-details').innerHTML = cb
            $('#ph-body, #footer').addClass('d-none');
            $('.ph-close, #phonefullspec').animate({
            }, 1000 ).removeClass('d-none');
            Fancybox.bind("[data-fancybox]", {
                closeButton: "top",
                Image: {
                    zoom: true,
                },

                on: {
                    initLayout: (fancybox) => {
                        // Create top bar
                        const top = document.createElement("div");
                        top.classList.add("fancybox__top");

                        // Create counter
                        const counter = document.createElement("div");
                        counter.classList.add("fancybox__counter");
                        top.appendChild(counter);
                        fancybox.$counter = counter;

                        fancybox.$backdrop.after(top);
                    },
                    "initCarousel Carousel.change": (fancybox) => {
                        // Update counter
                        fancybox.$counter.innerHTML = `${fancybox.Carousel.page + 1} / ${
                            fancybox.Carousel.pages.length
                        }`;
                    },
                },
            });
            document.querySelector('header').style.display = 'none'
            $('html, body').animate({ scrollTop: 0 }, 'slow')
            document.querySelector('#phonefullspec').classList.remove('d-none')
            Notiflix.Loading.Remove();

        })

    }
    else {
        errorMsg()
        Notiflix.Block.Remove();
    }

}
document.querySelector('#searchphone').addEventListener('click', () => {
    var phonemodel = document.getElementById('phonemodel').value.trim()
getSpec(phonemodel)
    siteInfo.then(res => {
        window.location = res.siteurl + shareIndex + phonemodel
    })
})

//9) Go Back To Header

document.querySelector('#closespec').addEventListener('click', ()=> {
    document.getElementById('phonefullspec').classList.add('d-none')
    document.getElementById('up-angle').classList.remove('d-none')
    document.querySelector('header').style.display = 'block'
})

//10) Go Back To Specification View
document.querySelector('#up-angle').addEventListener('click', ()=> {
    document.getElementById('phonefullspec').classList.remove('d-none')
    document.getElementById('up-angle').classList.add('d-none')
    document.querySelector('header').style.display = 'none'
})
//11) Hide Angle Icon On Scroll Jquery

$(window).scroll(function () {
    var mybtn = $('#closespec')
    if ($(this).scrollTop() > 1) {

        mybtn.addClass('d-none')

    } else {
        mybtn.removeClass('d-none')
    }
});

//12) Social sharer


//13) Share Page, Facebook, twitter, Whatsapp

 var shareIndex = '?q=';

function   socialPopUp(url)
{
    var x = screen.width / 2 - 700 / 2;
    var y = screen.height / 2 - 450 / 2;
    window.open( url, 'sharegplus', 'height=600,width=600,left=' + x + ',top=' + y);
    return false;
}

document.querySelector('#sharefb').addEventListener('click', ()=> {
    Notiflix.Loading.Circle('Please wait...')
    eventTrigger = true;

    if (eventTrigger) {
        siteInfo.then(res => {
            let shareUrl = res.siteurl + shareIndex + phonemodel
            let phonemodel = document.querySelector('#phoneSlug').value;

            let encodeUrl = encodeURIComponent(shareUrl)
            socialPopUp('https://www.facebook.com/sharer/sharer.php?u='+encodeUrl)
        })

        Notiflix.Loading.Remove()
        successShare()
    }

});


document.querySelector('#sharetw').addEventListener('click', ()=> {
    Notiflix.Loading.Circle('Please wait...')
    eventTrigger = true;
    let phonemodel = document.querySelector('#phoneSlug').value;
    let title = document.getElementById('mainTitle').innerText;
    let desc = document.getElementById('secondtitle').innerText;
    let img = document.getElementById('phoneImg').getAttribute('src');
    if (eventTrigger) {
        siteInfo.then(res => {
            let shareUrl = res.siteurl+shareIndex+phonemodel
            let encodeUrl = encodeURIComponent(shareUrl)
            socialPopUp("https://twitter.com/intent/tweet?url="+encodeUrl)

            Notiflix.Loading.Remove()
            successShare()
        })


    }

})

document.querySelector('#sharewht').addEventListener('click', ()=> {
    Notiflix.Loading.Circle('Please wait...')
    eventTrigger = true;
    let phonemodel = document.querySelector('#phoneSlug').value;
    let title = document.getElementById('mainTitle').innerText;
    let desc = document.getElementById('secondtitle').innerText;
    let img = document.getElementById('phoneImg').getAttribute('src');
    if (eventTrigger) {
        siteInfo.then(res => {
            let shareUrl = res.siteurl + shareIndex + phonemodel
            let encodeUrl = encodeURIComponent(shareUrl)

            socialPopUp("https://api.whatsapp.com/send/?text=" + encodeUrl)
        })
        Notiflix.Loading.Remove()
        successShare()
    }

})

document.querySelector('#shareCopy').addEventListener('click', ()=> {
    Notiflix.Loading.Circle('Please wait...')

    eventTrigger = true;
    if (eventTrigger) {

        siteInfo.then(res => {
            let phonemodel = document.querySelector('#phoneSlug').value;
            let shareUrl = res.siteurl + shareIndex + phonemodel

            let encodeUrl = encodeURIComponent(shareUrl)
            var elem = document.createElement('input')
            elem.setAttribute('value', shareUrl)
            elem.setAttribute('id', 'copyValue')
            elem.classList.add('d-none')
            let elec = document.getElementById('shareCopy')
            elec.append(elem)
            let copyValue = document.getElementById('copyValue')
            copyValue.classList.remove('d-none')

            copyValue.select()

            copyValue.setSelectionRange(0, 99999)
            document.execCommand("copy");
            copyValue.classList.add('d-none')
            Notiflix.Notify.Success('Link Copied')
            copyValue.remove()
        })
        Notiflix.Loading.Remove()
    }

})

const getShareUrl = function () {
    let seturl = decodeURIComponent(window.location.href)

    let urlArray = seturl.split('/');

    let value = seturl.substring(seturl.lastIndexOf('/') + 1);
    var shareSlug = value.split('q=')


    if (shareSlug[1]) {

        getSpec(shareSlug[1])

    }
}

getShareUrl()
