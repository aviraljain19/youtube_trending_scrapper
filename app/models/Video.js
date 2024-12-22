const mongoose = require("mongoose");

const VideoSchema = new mongoose.Schema({
  videoId: { type: String, unique: true, required: true },
  title: String,
  description: String,
  url: String,
  thumbnails: Object,
  views: String,
  likes: String,
  channelTitle: String,
  channelDescription: String,
  channelThumbnails: Object,
  channelSubscribers: String,
  channelUrl: String,
  fetchedAt: String,
});

module.exports = mongoose.model("Video", VideoSchema);