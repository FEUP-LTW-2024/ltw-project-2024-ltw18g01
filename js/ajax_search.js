const searchItems = document.querySelector('#search-data')
if (searchItems) {
  searchItems.addEventListener('input', async function() {
    const response = await fetch('../actions/search_items.php?search=' + this.value)
    const items = await response.json()
    
    const existingImageDisplay = document.querySelector('.image_display');
    if (existingImageDisplay) {
      existingImageDisplay.remove();
    }

    const imagedisplay = document.createElement('div')
    imagedisplay.className = 'image_display'

    for (const item of items) {
        const image_wrapper = document.createElement('div')
        image_wrapper.className = 'image_wrapper'

        const anchor = document.createElement('a')
        anchor.href = "/../pages/item.php?itemId=" + item.itemId

        const img = document.createElement('img')
        img.src = item.image_url
        anchor.appendChild(img)

        const p = document.createElement('p')
        p.textContent = item.price + "€ | " + item.likes + " likes"
        anchor.appendChild(p)

        const form = document.createElement('form')
        form.method = "POST"
        form.action = "/../actions/like_action.php"

        const inputItemId = document.createElement('input')
        inputItemId.type = "hidden"
        inputItemId.name = "itemId"
        inputItemId.value = item.itemId
        form.appendChild(inputItemId)

        const inputUserId = document.createElement('input')
        inputUserId.type = "hidden"
        inputUserId.name = "userId"
        inputUserId.value = "<?php echo $session->getId(); ?>"
        form.appendChild(inputUserId)
        
        const button = document.createElement('button')
        button.id = (wishlistItemIds.includes(item.itemId)) ? 'liked' : ""
        form.appendChild(button)

        anchor.appendChild(form)
        image_wrapper.appendChild(anchor); 
        imagedisplay.appendChild(image_wrapper); 
    }

    document.body.appendChild(imagedisplay);
  })
}
