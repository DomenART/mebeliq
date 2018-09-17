import UIkit from 'uikit'
window.UIkit = UIkit
UIkit.use(require('uikit/dist/js/uikit-icons'))

function objectifyForm(formArray) {//serialize data function
  var returnArray = {};
  for (var i = 0; i < formArray.length; i++){
    returnArray[formArray[i]['name']] = formArray[i]['value'];
  }
  return returnArray;
}

function getParams() {
  return window.location.search.replace('?','').split('&').reduce((p,e) => {
    const a = e.split('=')
    p[decodeURIComponent(a[0])] = decodeURIComponent(a[1])
    return p
  }, {})
}

function number_format( number, decimals, dec_point, thousands_sep ) {
  var i, j, kw, kd, km;

  // input sanitation & defaults
  if( isNaN(decimals = Math.abs(decimals)) ){
    decimals = 2;
  }
  if( dec_point == undefined ){
    dec_point = ",";
  }
  if( thousands_sep == undefined ){
    thousands_sep = ".";
  }

  i = parseInt(number = (+number || 0).toFixed(decimals)) + "";

  if( (j = i.length) > 3 ){
    j = j % 3;
  } else{
    j = 0;
  }

  km = (j ? i.substr(0, j) + thousands_sep : "");
  kw = i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + thousands_sep);
  //kd = (decimals ? dec_point + Math.abs(number - i).toFixed(decimals).slice(2) : "");
  kd = (decimals ? dec_point + Math.abs(number - i).toFixed(decimals).replace(/-/, 0).slice(2) : "");


  return km + kw + kd;
}

document.querySelectorAll('.gallery, .lightbox').forEach(item => {
    UIkit.lightbox(item)
})

document.querySelectorAll('.js-gallery').forEach(gallery => {
  const main = gallery.querySelector('.js-gallery-main')
  const lightbox = gallery.querySelector('.js-gallery-lightbox')
  const lightboxLinks = lightbox.querySelectorAll('a')
  const thumbnailsWrap = gallery.querySelector('.js-gallery-thumbnails')
  const thumbnails = thumbnailsWrap.querySelectorAll('img')
  const slider = UIkit.slider(thumbnailsWrap)

  thumbnails.forEach(img => {
    img.addEventListener('click', function(e) {
      e.preventDefault()
      thumbnails.forEach(row => row.classList.remove('active'))
      img.classList.add('active')
      slider.show(Array.prototype.indexOf.call(thumbnails, img))
      main.src = img.dataset.large
      main.dataset.full = img.dataset.full
    })
  })

  UIkit.util.on(thumbnailsWrap, 'itemshow', function (e) {
    e.target.querySelector('img').classList.add('active')
  })

  main.addEventListener('click', function(e) {
    e.preventDefault()

    let active = 0
    thumbnails.forEach((row, key) => {
      if (row.classList.contains('active')) {
        active = key
      }
    })

    lightboxLinks[active].click()
  })
})

// window.addEventListener('scroll', function(e) {
//     const totop = document.querySelector('.js-totop')
//
//     if (window.scrollY > 300) {
//         totop.classList.add('totop_visible')
//     } else {
//         totop.classList.remove('totop_visible')
//     }
// })

document.addEventListener("DOMContentLoaded", function() {
    const footer = document.querySelector('.js-footer')
    const page = document.querySelector('.js-page')

    page.style.minHeight = `${window.innerHeight - footer.offsetHeight}px`
})

document.querySelectorAll('.catalog-menu__dropdown').forEach(item => {
    const params = {}

    if (window.matchMedia("(max-width: 959px)").matches) {
        params.mode = 'click'
    }

    UIkit.dropdown(item, params)

    UIkit.util.on(item, 'show', function(e) {
        document.querySelector('.catalog-menu').classList.add('catalog-menu_dropdown')
    })
    UIkit.util.on(item, 'hide', function(e) {
        document.querySelector('.catalog-menu').classList.remove('catalog-menu_dropdown')
    })
})

document.querySelectorAll('.js-product-tabs').forEach(tabs => {
  const list = tabs.querySelectorAll('li')
  tabs.classList.remove('uk-hidden')

  if (window.matchMedia("(max-width: 639px)").matches) {
    list.forEach(row => {
      const title = document.createElement('div')
      title.classList.add('uk-accordion-title', 'product-accordion__title')
      title.innerHTML = row.dataset.title
      const content = document.createElement('div')
      content.classList.add('uk-accordion-content', 'product-accordion__content')
      content.innerHTML = row.innerHTML
      row.innerHTML = ''
      row.appendChild(title)
      row.appendChild(content)
      UIkit.accordion(tabs)
    })
  } else {
    const heads = document.createElement('ul')
    heads.classList.add('uk-tab')
    tabs.classList.add('uk-switcher')
    list.forEach(row => {
      row.classList.add('product-tabs__panel')
      const head = document.createElement('li')
      head.classList.add('product-tabs__tab')
      head.innerHTML = row.dataset.title
      heads.appendChild(head)
      tabs.parentNode.insertBefore(heads, tabs)
      UIkit.tab(heads)
    })
  }
})

if (window.matchMedia("(max-width: 959px)").matches) {
    UIkit.dropdown(document.querySelector('.catalog-menu'), {
        mode: 'click'
    })
}

document.querySelectorAll('.js-crosssell-load-all').forEach(all => {
  all.addEventListener('click', function(event) {
    const list = document.querySelector('.js-crosssell-list')

    jQuery.post('/wp-admin/admin-ajax.php', {
      action: 'load_crosssell',
      product: event.target.dataset.product
    }, function(response) {
      list.innerHTML = response
      event.target.style.display = 'none'
    })
  })
})

document.querySelectorAll('.js-cart-accordion').forEach(accordion => {
  const params = getParams()

  if (!params['key']) {
    const component = UIkit.accordion(accordion, {
      collapsible: false,
      active: params['key'] ? 2 : 0
    })

    jQuery(accordion).on('click', '.js-cart-go_to_order', function() {
      component.items[1].classList.remove('uk-hidden')
      component.toggle(1)
    })

    jQuery(accordion).on('click', '.js-cart-go_to_cart', function() {
      component.toggle(0)
      component.items[1].classList.add('uk-hidden')
    })
  } else {
    jQuery([document.documentElement, document.body]).animate({
      scrollTop: jQuery(accordion).offset().top
    }, 1000)
  }
})

const cart = jQuery('.woocommerce-cart-form');
cart.on('change', '.quantity input', function () {
  const data = objectifyForm(cart.serializeArray());
  data.update_cart = 'update_cart';

  cart.addClass('loading');
  jQuery.post(cart.attr('action'), data, function (response) {
    const new_cart = jQuery(document.createElement('div')).html(response).find('.woocommerce-cart-form')
    cart.html(new_cart.html());
    cart.removeClass('loading');
  });
});

document.querySelectorAll('.wpcf7').forEach(wrap => {
  const getModal = el => el.classList.contains('uk-modal') ? el : getModal(el.parentElement)
  const modal = getModal(wrap)

  wrap.addEventListener('wpcf7mailsent', () => {
    wrap.classList.add('wpcf7_success')
    setTimeout(() => {
      modal.__uikit__.modal.hide()
      wrap.classList.remove('wpcf7_success')
    }, 3000)
  })
})

document.querySelectorAll('.attribute-toggle').forEach(attribute => {
  const default_value = attribute.dataset.default
  const btn_no = attribute.querySelector('.attribute-toggle-switcher__value_no')
  const btn_yes = attribute.querySelector('.attribute-toggle-switcher__value_yes')
  const inputs = attribute.querySelectorAll('.attribute-toggle-values input')

  btn_no.addEventListener('click', function (e) {
    attribute.classList.remove('attribute-toggle_open')
    inputs.forEach(input => {
      if (input.value === default_value) {
        input.click()
      }
      // input.checked = input.value === default_value
    })
  })

  btn_yes.addEventListener('click', function (e) {
    attribute.classList.add('attribute-toggle_open')
  })
})

document.querySelectorAll('form[data-product_variations]').forEach(form => {
  const variations = jQuery.parseJSON(form.dataset.product_variations)
  const inputs = form.querySelectorAll('input,select')
  const price = form.querySelector('.js-product-price')
  const updatePrice = () => {
    const data = objectifyForm(jQuery(form).serializeArray())
    let display_price = null
    variations.forEach(variation => {
      let success = false
      Object.keys(variation.attributes).forEach(key => {
        if (variation.attributes[key] !== '' && data[key] === variation.attributes[key]) {
          success = true
        }
      })
      if (success) {
        display_price = variation.display_price
      }
    })
    const currencySymbol = price.querySelector('.woocommerce-Price-currencySymbol').cloneNode(true)
    jQuery(price).html('<span class="woocommerce-Price-amount amount">' + number_format(display_price, 0, '.', ' ') + '&nbsp;</span>').append(currencySymbol)
  }

  inputs.forEach(input => input.addEventListener('change', updatePrice))
  updatePrice()
})

document.querySelectorAll('[href="#individual"]').forEach(element => {
  UIkit.toggle(element)
})