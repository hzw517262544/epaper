package com.bootdo.epaper.service.impl;

import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Service;

import java.util.List;
import java.util.Map;

import com.bootdo.epaper.dao.RectDao;
import com.bootdo.epaper.domain.RectDO;
import com.bootdo.epaper.service.RectService;



@Service
public class RectServiceImpl implements RectService {
	@Autowired
	private RectDao rectDao;
	
	@Override
	public RectDO get(Integer id){
		return rectDao.get(id);
	}
	
	@Override
	public List<RectDO> list(Map<String, Object> map){
		return rectDao.list(map);
	}
	
	@Override
	public int count(Map<String, Object> map){
		return rectDao.count(map);
	}
	
	@Override
	public int save(RectDO rect){
		return rectDao.save(rect);
	}
	
	@Override
	public int update(RectDO rect){
		return rectDao.update(rect);
	}
	
	@Override
	public int remove(Integer id){
		return rectDao.remove(id);
	}
	
	@Override
	public int batchRemove(Integer[] ids){
		return rectDao.batchRemove(ids);
	}

	@Override
	public int removeByPublisId(Integer publishid) {
		return rectDao.removeByPublisId(publishid);
	}
}
