package com.bootdo.epaper.service.impl;

import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Service;

import java.util.List;
import java.util.Map;

import com.bootdo.epaper.dao.PaperDao;
import com.bootdo.epaper.domain.PaperDO;
import com.bootdo.epaper.service.PaperService;



@Service
public class PaperServiceImpl implements PaperService {
	@Autowired
	private PaperDao paperDao;
	
	@Override
	public PaperDO get(Long id){
		return paperDao.get(id);
	}
	
	@Override
	public List<PaperDO> list(Map<String, Object> map){
		return paperDao.list(map);
	}
	
	@Override
	public int count(Map<String, Object> map){
		return paperDao.count(map);
	}
	
	@Override
	public int save(PaperDO paper){
		return paperDao.save(paper);
	}
	
	@Override
	public int update(PaperDO paper){
		return paperDao.update(paper);
	}
	
	@Override
	public int remove(Long id){
		return paperDao.remove(id);
	}
	
	@Override
	public int batchRemove(Long[] ids){
		return paperDao.batchRemove(ids);
	}
	
}
