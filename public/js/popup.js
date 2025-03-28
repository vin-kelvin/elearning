function toggleFileInput() {
  var attachmentType = document.getElementById("attachment_type").value;
  var fileInput = document.getElementById("attachment_file");

  if (attachmentType == "video") {
    fileInput.accept = "video/*";
  } else if (attachmentType == "pdf") {
    fileInput.accept = "application/pdf";
  } else if (attachmentType == "doc") {
    fileInput.accept = ".doc,.docx,.xls,.xlsx";
  }

  fileInput.disabled = false;
}

