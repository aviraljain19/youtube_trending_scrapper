require("dotenv").config();
const express = require("express");
const mongoose = require('mongoose')
const router = express.Router();
const axios = require('axios');
const Video = require('../models/Video')

const API_KEY = process.env.API_KEY;

const TRENDING_URL = `https://www.googleapis.com/youtube/v3/videos?part=snippet,statistics,contentDetails&chart=mostPopular&regionCode=IN&maxResults=50&key=${API_KEY}`;

const fetchChannelDetails = async (channelId) => {
    try {
        const channelUrl = `https://www.googleapis.com/youtube/v3/channels?part=snippet,statistics&id=${channelId}&key=${API_KEY}`;
        const response = await axios.get(channelUrl);
        const channel = response.data.items[0];

        return {
            channelTitle: channel.snippet.title,
            channelDescription: channel.snippet.description || "No description available",
            channelSubscribers: channel.statistics.subscriberCount || "0",
            channelThumbnails: channel.snippet.thumbnails.default.url,
        };
    } catch (error) {
        console.error(`Error fetching channel details for ${channelId}:`, error.message);
        return {
            channelTitle: "Unknown Channel",
            channelDescription: "No description available",
            channelSubscribers: "0",
            channelThumbnails: "N/A",
        };
    }
};


const fetchTrendingVideos = async () => {
    try {
        console.log("Fetching YouTube Trending Videos...");
        const videoResponse = await axios.get(TRENDING_URL);
        const videoItems = videoResponse.data.items;
        const videosWithChannelDetails = [];
        for (const video of videoItems) {
            const videoDetails = {
                videoId: video.id,
                title: video.snippet.title,
                description: video.snippet.description,
                url: `https://www.youtube.com/watch?v=${video.id}`,
                thumbnails: video.snippet.thumbnails.default.url,
                views: video.statistics.viewCount || "0",
                likes: video.statistics.likeCount || "0",
            };
            const channelId = video.snippet.channelId;
            const channelDetails = await fetchChannelDetails(channelId);
            const completeVideoDetails = {
                ...videoDetails,
                ...channelDetails,
            };

            videosWithChannelDetails.push(completeVideoDetails);
        }

        console.log("Fetched Videos with Channel Details:", videosWithChannelDetails);
        return videosWithChannelDetails;
    } catch (error) {
        console.error("Error fetching trending videos:", error.message);
        return [];
    }
};

router.get("/fetch", async (req, res) => {
  try {
    const trendingVideos = await fetchTrendingVideos();
    for (const video of trendingVideos) {
      await Video.findOneAndUpdate(
        { videoId: video.videoId },
        {
          ...video,
          fetchedAt: `${new Date().getDate()}/${new Date().getMonth()}/${new Date().getFullYear()},${new Date().getHours()}:${new Date().getMinutes()}`,
        },
        { upsert: true, new: true }
      );
    }
    res.json({ success: true, message: "Trending videos updated." });
  } catch (error) {
    console.error(error);
    res.status(500).json({ error: "Failed to fetch videos" });
  }
});

router.get("/", async (req, res) => {
  try {
    const latestFetch = await Video.findOne()
      .sort({ fetchedAt: -1 })
      .select("fetchedAt");
    console.log(latestFetch);

    if (!latestFetch) {
      return res.status(200).json({ videos: [] });
    }
    const videos = await Video.find({ fetchedAt: latestFetch.fetchedAt });
    console.log(videos);

    res.json(videos);
  } catch (error) {
    console.error("Error fetching latest videos:", error);
    res.status(500).json({ error: "Failed to fetch latest videos" });
  }


});

router.get("/:id", async (req, res) => {
  try{
    const video = await Video.findOne({ videoId: req.params.id });
  if (video) {
    const moreVideoInfo = await videoInfo(video.url);
    const chanInfo = await channelInfo(
      `https://www.youtube.com${video.channelUrl}`
    );
    const updated = await Video.findOneAndUpdate(
      { videoId: video.videoId },
      { ...moreVideoInfo, ...chanInfo },
      { upsert: true, new: true }
    );
    res.json(updated);
  } else {
    res.status(404).json({ error: "Video not found" });
  }
  }
  catch (error) {
    console.error("Error fetching latest videos:", error);
    res.status(500).json({ error: "Failed to fetch video description" });
  }

});

module.exports = router;