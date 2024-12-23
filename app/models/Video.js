const mongoose = require("mongoose");

const VideoSchema = new mongoose.Schema({
  videoId: { type: String, unique: true, required: true },
  title: String,
  description: String,
  url: String,
  thumbnails: Object,
  views: Number,
  likes: Number,
  channelTitle: String,
  channelDescription: String,
  channelThumbnails: Object,
  channelSubscribers: Number,
  channelUrl: String,
  fetchedAt: Date,
});

module.exports = mongoose.model("Video", VideoSchema);
