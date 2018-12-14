package com.bootdo.epaper.service.impl;

import com.bootdo.common.utils.DateUtils;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Service;

import java.util.Date;
import java.util.List;
import java.util.Map;

import com.bootdo.epaper.dao.NewsDao;
import com.bootdo.epaper.domain.NewsDO;
import com.bootdo.epaper.service.NewsService;

import javax.annotation.Resource;


@Service
public class NewsServiceImpl implements NewsService {
	@Resource
	private NewsDao newsDao;
	
	@Override
	public NewsDO get(Integer id){
		return newsDao.get(id);
	}
	
	@Override
	public List<NewsDO> list(Map<String, Object> map){
		return newsDao.list(map);
	}
	
	@Override
	public int count(Map<String, Object> map){
		return newsDao.count(map);
	}
	
	@Override
	public int save(NewsDO news){
		news.setInfotime(DateUtils.format(new Date(),"yyyy-MM-dd"));
		news.setHits(0);
		return newsDao.save(news);
	}
	
	@Override
	public int update(NewsDO news){
		return newsDao.update(news);
	}
	
	@Override
	public int remove(Integer id){
		return newsDao.remove(id);
	}
	
	@Override
	public int batchRemove(Integer[] ids){
		return newsDao.batchRemove(ids);
	}
	
}
