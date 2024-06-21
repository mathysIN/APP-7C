const refreshDelay = 5000;

async function autoRefresh() {
  await fetch(location.href)
    .then((response) => {
      if (!response.ok) {
        throw new Error("Network response was not ok " + response.statusText);
      }
      return response.text();
    })
    .then((html) => {
      const parser = new DOMParser();
      const doc = parser.parseFromString(html, "text/html");

      const newContent = doc.getElementsByClassName("content")[0].innerHTML;

      document.getElementsByClassName("content")[0].innerHTML = newContent;

      const scripts = document.querySelectorAll(".content script");
      scripts.forEach((script) => {
        const newScript = document.createElement("script");
        newScript.textContent = script.textContent;
        document.body.appendChild(newScript).parentNode.removeChild(newScript);
      });
    })
    .catch((error) => {
      console.error("There was a problem with the fetch operation:", error);
    });
  setTimeout(autoRefresh, refreshDelay);
}

setTimeout(autoRefresh, refreshDelay);
